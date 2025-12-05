<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;

class MojaloopService
{
    protected Client $client;
    protected string $baseUrl;
    protected string $payerDisplayName;
    protected string $payerIdType;
    protected string $payerIdValue;

    public function __construct()
    {
        $this->baseUrl = config('services.mojaloop.base_url', 'http://localhost:4001');
        $this->payerDisplayName = config('services.mojaloop.payer_display_name', 'MaPension.BJ');
        $this->payerIdType = config('services.mojaloop.payer_id_type', 'MSISDN');
        $this->payerIdValue = config('services.mojaloop.payer_id_value', '123456789');
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
            'connect_timeout' => 10,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);
    }

    /**
     * Vérifier si un bénéficiaire existe dans le système Mojaloop
     */
    public function verifyParty(string $idType, string $idValue): array
    {
        try {
            $response = $this->client->get("/parties/{$idType}/{$idValue}");
            $data = json_decode($response->getBody()->getContents(), true);
            
            return [
                'success' => true,
                'exists' => true,
                'party' => $data,
                'message' => 'Bénéficiaire trouvé'
            ];
        } catch (GuzzleException $e) {
            $statusCode = $e->getCode();
            
            if ($statusCode === 404) {
                return [
                    'success' => true,
                    'exists' => false,
                    'message' => 'Bénéficiaire non trouvé'
                ];
            }
            
            Log::error('Mojaloop party verification error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'exists' => false,
                'message' => 'Erreur lors de la vérification: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Effectuer un transfert via Mojaloop TTK-SDK
     */
    public function sendTransfer(
        string $beneficiaryName,
        string $beneficiaryIdType,
        string $beneficiaryIdValue,
        float $amount,
        string $currency = 'XOF',
        string $note = 'Paiement pension retraite',
        ?string $homeTransactionId = null
    ): array {
        try {
            // Générer un ID de transaction unique si non fourni
            $homeTransactionId = $homeTransactionId ?? $this->generateTransactionId();
            
            $payload = [
                'from' => [
                    'displayName' => $this->payerDisplayName,
                    'idType' => $this->payerIdType,
                    'idValue' => $this->payerIdValue
                ],
                'to' => [
                    'idType' => $beneficiaryIdType,
                    'idValue' => $beneficiaryIdValue
                ],
                'amountType' => 'SEND',
                'currency' => $currency,
                'amount' => (string) $amount,
                'transactionType' => 'TRANSFER',
                'note' => $note,
                'homeTransactionId' => $homeTransactionId
            ];

            Log::info('Mojaloop Transfer Request', [
                'homeTransactionId' => $homeTransactionId,
                'beneficiary' => $beneficiaryName,
                'amount' => $amount
            ]);

            $response = $this->client->post('/transfers', [
                'json' => $payload
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            
            Log::info('Mojaloop Transfer Response', [
                'homeTransactionId' => $homeTransactionId,
                'response' => $responseData
            ]);

            return [
                'success' => true,
                'home_transaction_id' => $homeTransactionId,
                'mojaloop_transaction_id' => $responseData['transferId'] ?? null,
                'response' => $responseData,
                'message' => 'Transfert effectué avec succès'
            ];

        } catch (GuzzleException $e) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getCode();
            
            // Récupérer le corps de la réponse d'erreur si disponible
            $errorResponse = null;
            if (method_exists($e, 'getResponse') && $e->getResponse()) {
                $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            }
            
            Log::error('Mojaloop Transfer Error', [
                'homeTransactionId' => $homeTransactionId ?? 'N/A',
                'statusCode' => $statusCode,
                'error' => $errorMessage,
                'response' => $errorResponse
            ]);
            
            return [
                'success' => false,
                'home_transaction_id' => $homeTransactionId ?? null,
                'mojaloop_transaction_id' => null,
                'response' => $errorResponse,
                'message' => $this->formatErrorMessage($statusCode, $errorMessage, $errorResponse)
            ];
        } catch (\Exception $e) {
            Log::error('Unexpected error in Mojaloop transfer: ' . $e->getMessage());
            
            return [
                'success' => false,
                'home_transaction_id' => $homeTransactionId ?? null,
                'mojaloop_transaction_id' => null,
                'response' => null,
                'message' => 'Erreur inattendue: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Générer un ID de transaction unique
     */
    protected function generateTransactionId(): string
    {
        return 'MAPENSION-' . strtoupper(Str::uuid()->toString());
    }

    /**
     * Formater le message d'erreur de manière compréhensible
     */
    protected function formatErrorMessage(int $statusCode, string $errorMessage, ?array $errorResponse): string
    {
        if ($errorResponse && isset($errorResponse['errorInformation'])) {
            return $errorResponse['errorInformation']['errorDescription'] ?? $errorMessage;
        }

        return match($statusCode) {
            400 => 'Données de transfert invalides',
            404 => 'Bénéficiaire non trouvé',
            500 => 'Erreur du serveur Mojaloop',
            503 => 'Service Mojaloop temporairement indisponible',
            default => "Erreur de transfert: {$errorMessage}"
        };
    }

    /**
     * Vérifier la santé du service Mojaloop
     */
    public function healthCheck(): bool
    {
        try {
            $response = $this->client->get('/health');
            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            Log::warning('Mojaloop health check failed: ' . $e->getMessage());
            return false;
        }
    }
}
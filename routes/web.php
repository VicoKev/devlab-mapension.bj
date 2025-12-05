<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BulkPaymentController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/bulk-payments', [BulkPaymentController::class, 'index'])->name('bulk-payment.index');
Route::post('/bulk-payments/upload', [BulkPaymentController::class, 'upload'])->name('bulk-payment.upload');
Route::post('/bulk-payments/import', [BulkPaymentController::class, 'import'])->name('bulk-payment.import');
Route::get('/bulk-payments/{id}', [BulkPaymentController::class, 'show'])->name('bulk-payment.show');
Route::post('/bulk-payments/{id}/process', [BulkPaymentController::class, 'process'])->name('bulk-payment.process');
Route::get('/bulk-payments/{id}/download', [BulkPaymentController::class, 'downloadReport'])->name('bulk-payment.download');
Route::get('/bulk-payments/{id}/refresh-status', [BulkPaymentController::class, 'refreshStatus'])->name('bulk-payment.refresh');

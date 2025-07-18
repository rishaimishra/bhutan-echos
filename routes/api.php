<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TimelineEntryController;
use App\Http\Controllers\Api\EBookController;
use App\Http\Controllers\Api\AudioClipController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\LiveSessionController;
use App\Http\Controllers\Api\LiveQuizController;
use App\Http\Controllers\Api\LivePollController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\LiveQuestionController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\UserReportController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/send-signup-mail', [RegisterController::class, 'sendSignupMail']);
Route::get('/verify-email/{id}', [RegisterController::class, 'emailVerify']);

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'profile']);
Route::middleware('auth:sanctum')->put('/profile', [ProfileController::class, 'updateProfile']);
Route::middleware('auth:sanctum')->delete('/delete-account', [ProfileController::class, 'deleteAccount']);
Route::middleware('auth:sanctum')->put('/profile-info-update', [ProfileController::class, 'profileInfoUpdate']);

Route::get('/timeline-entries', [TimelineEntryController::class, 'index']);
Route::middleware('auth:sanctum')->post('/timeline-entries', [TimelineEntryController::class, 'store']);
Route::get('/ebooks', [EBookController::class, 'index']);
Route::get('/ebooks/{ebook}', [EBookController::class, 'show']);

Route::get('/audio-clips', [AudioClipController::class, 'index']);
Route::middleware('auth:sanctum')->get('/audio-clips/{id}/download', [\App\Http\Controllers\Api\AudioClipController::class, 'download']);

Route::get('/notifications', [NotificationController::class, 'index']);

// Password Reset Routes
Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
Route::get('/verify-reset-token/{token}', [PasswordResetController::class, 'verifyResetToken']);
Route::post('reset-password/{token}', [PasswordResetController::class, 'resetPassword']);

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);

Route::get('/live-sessions', [LiveSessionController::class, 'index']);
Route::get('/live-sessions/{liveSession}', [LiveSessionController::class, 'show']);

Route::get('/live-quizzes', [\App\Http\Controllers\Api\LiveQuizController::class, 'index']);
Route::get('/live-quizzes/{id}', [\App\Http\Controllers\Api\LiveQuizController::class, 'show']);
Route::middleware('auth:sanctum')->post('/live-quizzes/{quiz}/questions/{question}/answer', [\App\Http\Controllers\Api\LiveQuizController::class, 'submitAnswer']);
Route::middleware('auth:sanctum')->get('/live-quizzes/{quiz}/my-answers', [\App\Http\Controllers\Api\LiveQuizController::class, 'myAnswers']);

// Live Polls API
Route::get('/live-polls', [LivePollController::class, 'index']);
Route::get('/live-polls/{id}', [LivePollController::class, 'show']);
Route::middleware('auth:sanctum')->post('/live-polls/{id}/vote', [LivePollController::class, 'vote']);
Route::get('/live-polls/{id}/results', [LivePollController::class, 'results']);

// Feedback API
Route::get('/feedback', [FeedbackController::class, 'index']);
Route::middleware('auth:sanctum')->post('/feedback', [FeedbackController::class, 'store']);
Route::get('/sessions/{sessionId}/feedback', [FeedbackController::class, 'sessionFeedback']);

Route::get('/media', [MediaController::class, 'index']);

Route::get('/live-questions', [LiveQuestionController::class, 'index']);
Route::middleware('auth:sanctum')->post('/live-questions', [LiveQuestionController::class, 'store']);

Route::get('/quizzes', [QuizController::class, 'index']);
Route::get('/quizzes/{id}', [QuizController::class, 'show']);
Route::middleware('auth:sanctum')->post('/quizzes', [QuizController::class, 'store']);
Route::middleware('auth:sanctum')->put('/quizzes/{id}', [QuizController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/quizzes/{id}', [QuizController::class, 'destroy']);
Route::middleware('auth:sanctum')->post('/quizzes/{id}/submit-answers', [QuizController::class, 'submitAnswers']);
Route::middleware('auth:sanctum')->get('/quizzes/{id}/my-result', [QuizController::class, 'myResult']);

Route::middleware('auth:sanctum')->post('/user-reports', [UserReportController::class, 'store']);





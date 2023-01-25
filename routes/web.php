<?php use Illuminate\Support\Facades\Route;use App\Http\Controllers\FaqController;use App\Http\Controllers\HomeController;use App\Http\Controllers\ArticlesController;use App\Http\Controllers\CheckoutController;use App\Http\Controllers\InvoicesController;use App\Http\Controllers\JournalsController;use App\Http\Controllers\ServicesController;use App\Http\Controllers\ArticlesEnController;use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ResearchesController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\Auth\ForgetController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ConferencesController;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\JournalsResearchesController;
use App\Http\Controllers\InternationalPublicationOrdersController;
use App\Http\Controllers\User\HomeController as UserHomeController;

Route::middleware(['guest'])->group(function(){Route::prefix('login')->group(function(){Route::controller(LoginController::class)->group(function(){Route::get('','index');Route::post('check','login');});});Route::prefix('register')->group(function(){Route::controller(RegisterController::class)->group(function(){Route::get('','index');Route::post('create','create');});});Route::get('forget-password',[ForgetController::class,'forget']);Route::get('reset-password/{email_hash}',[ForgetController::class,'reset']);Route::post('send-mail',[ForgetController::class,'send_mail']);Route::post('update-password/{email_hash}',[ForgetController::class,'update_password']);});Route::middleware(['UserAuth'])->group(function(){Route::prefix(userPrefix())->group(function(){Route::get('notification', function () {
            return view('main.notifications');
        });Route::get('logout',[LogoutController::class,'user_logout']);Route::get('/dashboard',[UserHomeController::class,'index']);

Route::controller(UsersController::class)->group(function(){
    Route::get('settings','settings');
    Route::post('profile/update','update');
    Route::post('update/profile-image','update_profile_image');
    Route::post('email-verification','send_email_verification');
    Route::get('email-verification/{token}','email_verification');
    Route::post('chat/store','chat_store');
    Route::get('chat/{id}','chat');
    Route::get('count-publication-prices','countPublicationPrices');
    Route::post('count-publication-prices','countPublicationPricesPost')->name('countPublicationPrices');
    
});

Route::prefix('conference')->group(function(){Route::controller(ConferencesController::class)->group(function(){Route::get('','all_conference');Route::get('create','create');Route::post('store','store');Route::post('update','update');Route::get('edit/{id}','edit');Route::delete('destroy','destroy');});Route::controller(CheckoutController::class)->group(function(){Route::get('checkout/{id}','checkout_conference');Route::post('response/checkout','checkout_conference_response');});});Route::prefix('international-publishing')->group(function(){Route::controller(InternationalPublicationOrdersController::class)->group(function(){Route::get('','index');Route::get('create','create');Route::post('store','store');Route::post('update','update');Route::get('edit/{id}','edit');Route::delete('destroy','destroy');});Route::controller(CheckoutController::class)->group(function(){Route::get('checkout/{id}','checkout_international_publishing');Route::post('response/checkout','checkout_international_publishing_response');});});

Route::prefix('researches')->group(function(){Route::controller(ResearchesController::class)->group(function(){
    Route::get('all','index');
    Route::get('/{id}','show')->name('current_user_researches');
    Route::post('delete_demande','deleteDemande')->name('research.delete_demande');
    Route::get('','create');Route::get('edit/{id}','edit');Route::delete('destroy','destroy');Route::post('store','store');Route::post('update','update');
    Route::get('/{id}/confirm_received','order_received_page');
    Route::get('/chats/old-chats','old_chats')->name('old_chats');
});
Route::controller(CheckoutController::class)->group(function(){Route::get('checkout/{id}','checkout_researches');Route::post('response/checkout','checkout_researches_response');});});});});Route::get('/',[HomeController::class,'index']);Route::get("faqs",[FaqController::class,'show']);Route::get("services",[ServicesController::class,'show']);Route::get("search",[HomeController::class,'search']);Route::get("journals",[JournalsController::class,'journals']);Route::prefix('journal')->group(function(){Route::controller(JournalsController::class)->group(function(){Route::get('{slug}','show');});});Route::get("versions/{slug}",[JournalsController::class,'versions']);Route::get("team/{slug}",[JournalsController::class,'team']);Route::get("publication-ethics/{slug}",[JournalsController::class,'publication_ethics']);Route::get("how-to-submit-the-article/{slug}",[JournalsController::class,'how_to_submit_the_article']);Route::get("publication-price/{slug}",[JournalsController::class,'publication_price']);Route::get("reviewers-instructions/{slug}",[JournalsController::class,'reviewers_instructions']);Route::get("international-credits/{slug}",[JournalsController::class,'international_credits']);Route::get("authors-instructions/{slug}",[JournalsController::class,'authors_instructions']);Route::prefix('researches')->group(function(){Route::controller(JournalsResearchesController::class)->group(function(){Route::get('{slug}/version/{version_id}','researches');Route::get('{slug}','show');});});Route::get("blog",[ArticlesController::class,'blog']);Route::prefix('article')->group(function(){Route::controller(ArticlesController::class)->group(function(){Route::get('{slug}','show');});});Route::get("en/blog",[ArticlesEnController::class,'blog']);Route::prefix('en/article')->group(function(){Route::controller(ArticlesEnController::class)->group(function(){Route::get('{slug}','show');});});Route::get("blog-single.php",[ArticlesController::class,'old_article']);Route::post("subscribe",[SubscribersController::class,'store']);Route::get("download-my-certificate/{token}",[UsersController::class,'download_certificate']);Route::prefix('invoice')->group(function(){Route::controller(InvoicesController::class)->group(function(){Route::get('{token_id}','invoice');});Route::controller(CheckoutController::class)->group(function(){Route::post('response/checkout','checkout_invoice_response');});
   
});
   
Route::prefix('invoice')->group(function () {
    Route::controller(InvoicesController::class)->group(function () {
        Route::get('{token_id}', 'invoice');
    });
    Route::controller(CheckoutController::class)->group(function () {
        Route::post('response/checkout', 'checkout_invoice_response');
    });
    Route::get('read-now/{id}',[InternationalPublicationOrdersController::class, 'readNotification'])->name('read_notificatio');
    Route::get('read-now/{type}/{noti}/{id?}',[InternationalPublicationOrdersController::class, 'readNotificationConferenceRequest'])->name('read-now');
});
Route::get('u/invoice/my-invoices', [InvoicesController::class,'user_invoices'])->name('my-invoices');


<?php

namespace App\Console\Commands;

use App\Models\Invoices;
use App\Models\Versions;
use Illuminate\Support\Str;
use App\Models\UsersResearches;
use Illuminate\Console\Command;
use App\Models\JournalsResearches;
use Illuminate\Support\Facades\DB;

class AutoJournalResearchesPublishing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'researches:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'start Auto publish of journal researches';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $months = ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];

        $this->info('start of research auto pubish666.');
        $journals = DB::table('journals')->whereDate('next_version',date('Y-m-d'))->get();
   
        foreach ($journals as $journal) {
    
            $new_version_exists = Versions::where('journal_id',$journal->id)
            ->where('year',date('Y'))
            ->where('month',date('m'))
            ->where('day',date('d'))
            ->first();
 
            if(!$new_version_exists && strtotime($journal->next_version) && (date('Y-m-d',strtotime($journal->next_version)) == date('Y-m-d')))
            {
                //get date of last version
                $next_version_name = $journal->next_version_name;
                $last_version =  Versions::where('journal_id',$journal->id)
                                        ->whereDate('created_at','<',date('Y-m-d'))
                                        ->latest()
                                        ->first();

                    $exists = Versions::where('journal_id',$journal->id)
                    ->where('year',date('Y'))
                    ->where('month',date('m'))
                    ->where('day',date('d'))
                    ->firstOrCreate([
                        'version' => $next_version_name,
                        'year' => date('Y'),
                        'month' =>  date('m'),
                        'journal_id' => $journal->id,
                        'day' =>  date('d')   
                    ]);
        
                    $last_version_publish_date = date('Y-m-d',strtotime($last_version->year.'-'.(array_search($last_version->month,$months)+1).'-'.$last_version->day));
                
                    if($last_version_publish_date){
                    $paid_researches_invoices = Invoices::whereNotNull('paid_at')
                                                        ->whereBetween(DB::raw('DATE(paid_at)'), array($last_version_publish_date, date('Y-m-d')))
                                                        ->where('payment_response','1')
                                                        ->where('journal_id',$journal->id)
                                                        ->pluck('users_researches_id')
                                                        ->toArray();
                                                
                    foreach ($paid_researches_invoices as $research_id) {
                        $user_research = UsersResearches::with('user')->find($research_id);
                        if($user_research)
                        {
                            $journal_research = new JournalsResearches;
                            $journal_research->title =  $user_research->title;
                            $journal_research->slug = Str::slug($user_research->title);
                            $journal_research->abstract = $user_research->abstract;
                            $journal_research->author_name = $user_research->user->name;
                            $journal_research->file = $user_research->file;
                            $journal_research->keywords = $user_research->keywords;
                            $journal_research->journal_id = $user_research->journal_id;
                            $journal_research->version_id = $exists->id;
                            $journal_research->save();
                        }

                    }
                    
                        DB::table('journals')->where('slug',$journal->slug)->update(['next_version_name' => '']);
                
                    }
            }
        }
    } 
}

<?php

namespace App\Console\Commands;

use App\Models\Currency;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class UpdateCurrency extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating Currency';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $client = new Client();
        $response = $client->request('GET', 'http://api.nbp.pl/api/exchangerates/rates/a/eur/');
        $content = json_decode($response->getBody()->getContents(), TRUE);

        $getCurrencies = Currency::all();
        foreach ($getCurrencies as $currency) {
            if ($content['currency'] == $currency['name']) {
                $currency->update(['exchange_rate' => $content['rates'][0]['mid']]);
            }
            else {
                $currency = new Currency();
                $currency->name = $content['currency'];
                $currency->currency_code = $content['code'];
                $currency->exchange_rate = $content['rates'][0]['mid'];
                $currency->save();
            }
        }
    }

}

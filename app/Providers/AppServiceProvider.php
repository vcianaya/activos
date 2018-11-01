<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
		/**
		 * Bootstrap any application services.
		 *
		 * @return void
		 */
		public function boot()
		{
      setlocale(LC_TIME, 'es_ES');
      Carbon::setLocale('es');
			Schema::defaultStringLength(191);
		}

		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
				//
		}
	}

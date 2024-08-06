<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PengaturanAdministrasi;
use App\Models\Nasabah;

class DeductMonthlyFees extends Command
{
    protected $signature = 'fees:deduct';
    protected $description = 'Deduct monthly administration fees from all accounts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $pengaturan = PengaturanAdministrasi::first();
        $nasabahs = Nasabah::all();

        foreach ($nasabahs as $nasabah) {
            if ($nasabah->saldo_total >= $pengaturan->administrasi_bulanan) {
                $nasabah->saldo_total -= $pengaturan->administrasi_bulanan;
                $nasabah->save();
            } else {
                // Optional: handle cases where saldo < administrasi_bulanan
                // For example, you might want to notify the user or log a warning
            }
        }

        $this->info('Monthly fees deducted successfully.');
    }
}

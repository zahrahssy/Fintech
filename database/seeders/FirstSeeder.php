<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FirstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {      
        User::create([
            "name" =>"Admin",
            "username" => "admin",
            "password" => Hash::make("admin"),
            "role" => "admin",
        ]);
        User::create([
            "name" =>"Tenizen Bank",
            "username" => "bank",
            "password" => Hash::make("bank"),
            "role" => "bank",
        ]);
        User::create([
            "name" => "Tenizen Mart",
            "username" => "kantin",
            "password" => Hash::make("kantin"),
            "role" => "kantin",
        ]);
        User::create([
            "name" => "Zahrah",
            "username" => "zahrah",
            "password" => Hash::make("zahrah"),
            "role" => "siswa",
        ]);
        Student::create([
            "user_id"  => 4,
            "nis" => "12351",
            "classroom" => "XII RPL"
        ]);
        Category::create([
            "name" => "minuman"
        ]);
        Category::create([
            "name" => "makanan"
        ]);
        Category::create([
            "name" => "snack"
        ]);
        Product::create([
            "name" => "Ice Lemon Tea",
            "price" => 5000,
            "stock" => 100,
            "photo" => "images/lemon-tea.png",
            "description" => "Es teh doang sih",
            "category_id" => 1,
            "stand" => 2
        ]);
        Product::create([
            "name" => "Bakso",
            "price" => 10000,
            "stock" => 100,
            "photo" => "images/bakso.png",
            "description" => "Bakso daging",
            "category_id" => 2,
            "stand" => 1
        ]);
        Product::create([
            "name" => "Risoles",
            "price" => 3000,
            "stock" => 50,
            "photo" => "images/risol.png",
            "description" => "Risol isi sayur",
            "category_id" => 3,
            "stand" => 1
        ]);
        Product::create([
            "name" => "Piscok",
            "price" => 3000,
            "stock" => 30,
            "photo" => "images/piscok.png",
            "description" => "Pisang Coklat",
            "category_id" => 3,
            "stand" => 1
        ]);
        Product::create([
            "name" => "Cireng",
            "price" => 2000,
            "stock" => 50,
            "photo" => "images/cireng.png",
            "description" => "Cireng isi",
            "category_id" => 3,
            "stand" => 1
        ]);
        Product::create([
            "name" => "Aneka Gorengan",
            "price" => 3000,
            "stock" => 50,
            "photo" => "images/gorengan.png",
            "description" => "Bakwan, tempe, tahu, dll",
            "category_id" => 3,
            "stand" => 1
        ]);
        Wallet::create([
            "user_id" => 4,
            "credit" => 100000,
            "description" => "pembukaan buku rekening"
        ]);

        Transaction::create([
            "user_id" => 4,
            "product_id" => 3,
            "status" => "di keranjang",
            "order_id" => "INV_12345",
            "price" => 10000,
            "quantity" => 2
        ]);

        $transactions = Transaction::where('order_id', 'INV_12345');
        $total_debit = 0;

        foreach($transactions as $transaction){
            $total_price = $transaction->price * $transaction->quantity;
            $total_debit = $total_price;
        }

        Wallet::create([
            "user_id" => 4,
            "debit" => $total_debit,
            "description" => "pembelian produk"
        ]);

        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                "status" => "dibayar"
            ]);
        }
    }
}

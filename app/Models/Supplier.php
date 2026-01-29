<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = ['supplier_code','name','address','tin','payment_terms','contact_person','person_contact','email','fax','website','currency','supplier_type','gl_account_code','tax_type','payment_method','bank_name','bank_account_number','status','remarks','date_added','added_by','date_updated','updated_by'];
}
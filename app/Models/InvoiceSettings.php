<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSettings extends Model
{
    use HasFactory;

    protected $table = 'invoice_settings';

    protected $fillable = [
        'logo',
        'show_logo',
        'site_name',
        'header_message',
        'footer_message',
        'contact_address',
        'contact_email',
        'contact_phone',
        'signature',
        'sho_signature',
        'status'
    ];
}

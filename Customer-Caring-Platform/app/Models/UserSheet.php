<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSheet extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'usersheet';

    // Specify the primary key
    protected $primaryKey = 'id';

    // Indicate that the primary key is auto-incrementing
    public $incrementing = true;

    // Specify the data types of attributes
    protected $keyType = 'int';

    protected $fillable = [
        'nper',
        'snd',
        'snd_group',
        'nama_cli',
        'alamat',
        'ubis',
        'desc_newbill',
        'usage_desc',
        'lama_berlangganan',
        'saldo',
        'no_hp',
        'email',
        'tanggal_caring_1',
        'petugas',
        'status',
        'tanggal_caring_2',
        'petugas_2',
        'status_2',
        'additional_info',
        'sheet_code',
        'branch',
        'sto',
        'status_paid',
        'totag',         // Integer attribute
        'payment_date',  // Add payment_date
    ];
    
    


}

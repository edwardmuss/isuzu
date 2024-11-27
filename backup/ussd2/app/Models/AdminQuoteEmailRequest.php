<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminQuoteEmailRequest extends Model
{
    protected $table = "tadminquoteemailrequests";
	
	public $timestamps = false;
	
	protected $fillable = [
		'recipient_email',
		'quote_name',
		'client_name',
		'processed'
	];
}

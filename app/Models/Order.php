<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'invoice_number', 'customer_name', 'customer_email', 'customer_phone',
        'customer_address', 'total_price', 'status', 'payment_method', 'order_type',
        'snap_token', 'tracking_number', 'notes', 'created_at', 'updated_at'
    ];

    // Relasi: 1 Order punya banyak Order Item
    public function items() {
        return $this->hasMany(OrderItem::class);
    }
    // Relasi ke User
    public function user() {
        return $this->belongsTo(User::class);
    }
}
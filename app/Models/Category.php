<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(["nama_kategori", "jenis", "warna_marker"])]
class Category extends Model {}

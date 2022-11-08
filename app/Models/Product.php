<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OpenApi\Annotations as OA;

/**
 * Class Product.
 *
 * @author  Bidarine Kawtar <kawtar.bidarine@gmail.com>
 *
 * @OA\Schema(
 *     description="Product model",
 *     title="Product model",
 *     @OA\Xml(
 *         name="Product"
 *     )
 * )
 **/

class Product extends Model
{
	use HasFactory;

	/**
	 * Override fillable property data.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title',
		'description',
		'price',
		'image',
		'user_id'
	];

	/**
	 * @OA\Property(format="int64")
	 *
	 * @var integer
	 */
	public $id;

	/**
	 * @OA\Property
	 *
	 * @var string
	 */
	public $title;

	/**
	 * @OA\Property
	 *
	 * @var string
	 */
	public $description;


	/**
	 * @OA\Property
	 *
	 * @var float
	 */
	public $price;


	/**
	 * @OA\Property
	 *
	 * @var string
	 */
	public $image;

	/**
	 * @var integer
	 *
	 * @OA\Property
	 */
	public $user_id;

	/**
	 * Project author's user model.
	 *
	 *  @var \App\Models\User
	 */
	public $user;

	/**
	 * User
	 *
	 * Get User Uploaded By Product
	 *
	 * @return object
	 */
	public function user(): object
	{
		return $this->belongsTo(User::class)->select('id', 'name', 'email');
	}

	// Add New Attribute to get image address
	protected $appends = ['image_url'];

	/**
	 * Get Added Image Attribute URL.
	 *
	 * @return string|null
	 */
	public function getImageUrlAttribute(): string | null
	{
		if (is_null($this->image) || $this->image === "") {
			return null;
		}

		return url('') . "/images/products/" . $this->image;
	}
}

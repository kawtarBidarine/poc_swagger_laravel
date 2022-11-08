<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel OpenApi Demo Documentation",
 *      description="L5 Swagger OpenApi description",
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 *
 * @OA\SecurityScheme(
 *    securityScheme="bearerAuth",
 *    in="header",
 *    name="bearerAuth",
 *    type="http",
 *    scheme="bearer",
 *    bearerFormat="JWT",
 * )
 *
 * @OA\Response(
 *    response="BadRequest",
 *		description="Bad request",
 *		@OA\JsonContent(@OA\Property(property="message", type="string", example="Bad request")) 
 * )
  *
 * @OA\Response(
 *    response="NotFound",
 *		description="Not Found",
 *		@OA\JsonContent(@OA\Property(property="message", type="string", example="Resource Not Found")) 
 * )
 *
 * Tag(
 *     name="Projects",
 *     description="API Endpoints of Projects"
 * )
 */



class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\ProductRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA; 

/**
 * @OA\PathItem(
 *   path="/api/products/{id}"
 * )
 */

class ProductsController extends Controller
{
    use ResponseTrait;
    /**
     * Product Repository class.
     *
     * @var ProductRepository
     */
    public $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        //$this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->productRepository = $productRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Get Product List",
     *     description="Get Product List as Array",
     *     operationId="index",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200,description="Get Product List as Array", @OA\JsonContent( type = "array" , @OA\Items(ref="#/components/schemas/Product"))),
     *     @OA\Response(response=400, ref="#/components/responses/BadRequest"),
		 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->productRepository->getAll();
            return $this->responseSuccess($data, 'Product List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/view/all",
     *     tags={"Products"},
     *     summary="All Products - Publicly Accessible",
     *     description="All Products - Publicly Accessible",
     *     operationId="indexAll",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="All Products - Publicly Accessible", @OA\JsonContent( type = "array" , @OA\Items(ref="#/components/schemas/Product")) ),
     *     @OA\Response(response=400, ref="#/components/responses/BadRequest"),
		 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
     * )
     */
    public function indexAll(ProductRequest $request): JsonResponse
    {
        try {
					$data = $this->productRepository->getPaginatedData($request->perPage);
					return $this->responseSuccess($data, 'Product List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/view/search",
     *     tags={"Products"},
     *     summary="All Products - Publicly Accessible",
     *     description="All Products - Publicly Accessible",
     *     operationId="search",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", description="search, eg; Test", example="Test", in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="All Products - Publicly Accessible", @OA\JsonContent( type = "array" , @OA\Items(ref="#/components/schemas/Product")) ),
     *     @OA\Response(response=400, ref="#/components/responses/BadRequest"),
		 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
     * )
     */
    public function search(ProductRequest $request): JsonResponse
    {
        try {
            $data = $this->productRepository->searchProduct($request->search, $request->perPage);
            return $this->responseSuccess($data, 'Product List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Create New Product",
     *     description="Create New Product",
     *     operationId="store",
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Product"),
     *      ),
     *      security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Create New Product", @OA\JsonContent(ref="#/components/schemas/Product") ),
     *     @OA\Response(response=400, ref="#/components/responses/BadRequest"),
		 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
     * )
     */
    public function store(ProductRequest $request): JsonResponse
    {
        try {
            $product = $this->productRepository->create($request->all());
            return $this->responseSuccess($product, 'New Product Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Show Product Details",
     *     description="Show Product Details",
     *     operationId="show",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Show Product Details", @OA\JsonContent(ref="#/components/schemas/Product") ),
     *     @OA\Response(response=400, ref="#/components/responses/BadRequest"),
		 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
     *     @OA\PathItem (path="/api/products/{id}",),
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->productRepository->getByID($id);
            if (is_null($data)) {
                return $this->responseError(null, 'Product Not Found', Response::HTTP_NOT_FOUND);
            }

            return $this->responseSuccess($data, 'Product Details Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Update Product",
     *     description="Update Product",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Product"),
     *      ),
     *     operationId="update",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Update Product", @OA\JsonContent(ref="#/components/schemas/Product")),
     *     @OA\Response(response=400, ref="#/components/responses/BadRequest"),
		 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
     * )
     */
    public function update(ProductRequest $request, $id): JsonResponse
    {
        try {
            $data = $this->productRepository->update($id, $request->all());
            if (is_null($data))
                return $this->responseError(null, 'Product Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseSuccess($data, 'Product Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Delete Product",
     *     description="Delete Product",
     *     operationId="destroy",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Delete Product", @OA\JsonContent(ref="#/components/schemas/Product")),
     *     @OA\Response(response=400, ref="#/components/responses/BadRequest"),
		 *     @OA\Response(response=404, ref="#/components/responses/NotFound"),
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $product =  $this->productRepository->getByID($id);
            if (empty($product)) {
                return $this->responseError(null, 'Product Not Found', Response::HTTP_NOT_FOUND);
            }

            $deleted = $this->productRepository->delete($id);
            if (!$deleted) {
                return $this->responseError(null, 'Failed to delete the product.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->responseSuccess($product, 'Product Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

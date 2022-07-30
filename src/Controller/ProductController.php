<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{

    /**
     * @Route("/product", name="product", methods={"GET","POST"})
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return JsonResponse
     */
    public function index(Request $request, ProductRepository $productRepository): JsonResponse
    {
        if ($request->getMethod() == 'POST') {
            $postData = [];
            $jsonData = json_decode($request->getContent(), true);
            if (!is_null($jsonData)) $postData = $jsonData;
            $product = $productRepository->newProduct($postData);
        } else {
            $result = $productRepository->getProducts();
            $product = $result["data"];
        }

        return $this->json($product);
    }

    /**
     * @Route("/product/{productId}", name="product_action", methods={"GET","PUT","DELETE"})
     * @param int $productId
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ProductRepository $productRepository
     * @return JsonResponse
     */
    public function productAction(int $productId,Request $request,SerializerInterface $serializer,ProductRepository $productRepository): JsonResponse
    {
        $result = ["isSuccess" => false, "message" => "İşlem yapılmadı", "data" => null];
        $product=$productRepository->find($productId);
        if($product==null){
            $result["message"]="Ürün bulunamadı";
            return $this->json($result);
        }
        switch ($request->getMethod()){
            case "GET":
                $result = json_decode($serializer->serialize($product, 'json'));
                break;
            case "PUT":
                $postData = [];
                $jsonData = json_decode($request->getContent(), true);
                if (!is_null($jsonData)) $postData = $jsonData;
                $product = $productRepository->updateProduct($product, $postData);
                $result = json_decode($serializer->serialize($product, 'json'));
                break;
            case "DELETE":
                $productRepository->remove($product,true);
                $result = ["isSuccess" => true, "message" => "İşlem başarılı", "data" => null];
                break;
        }
        return $this->json($result);
    }
}
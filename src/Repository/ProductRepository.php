<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function addOrUpdate(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function fieldCheck(array $postData, array $requiredFields): array
    {
        $result = ["isSuccess" => false, "message" => "İşlem yapılmadı", "data" => null];
        foreach ($requiredFields as $field) {
            if (!isset($postData[$field])) {
                $result["message"] = "Gerekli alan eksik: " . $field;
                return $result;
            }
        }
        $result["isSuccess"] = true;
        return $result;
    }

    /**
     * @param array $postData
     * @return array
     */
    public function newProduct(array $postData): array
    {
        $result = ["isSuccess" => false, "message" => "İşlem yapılmadı", "data" => null];
        $this->fieldCheck($postData, ["productName", "productStock", "productPrice"]);
        $product = new Product();
        $product
            ->setProductName((string)$postData["productName"])
            ->setProductDescription((string)$postData["productDescription"])
            ->setProductStock((int)$postData["productStock"])
            ->setProductPrice((float)$postData["productPrice"])
            ->setProductCreatedAt(new \DateTime());
        try {
            $this->addOrUpdate($product, true);
            $result["isSuccess"] = true;
            $result["message"] = "Ürün başarıyla eklendi";
            $result["data"] = $product;
        } catch (\Exception $e) {
            $result["message"] = $e->getMessage();
        }
        return $result;
    }

    #[ArrayShape(["isSuccess" => "bool", "message" => "string", "data" => "mixed|null"])]
    public function getProducts(): array
    {
        $result = ["isSuccess" => false, "message" => "İşlem Yapılmadı", "data" => null];
        try {
            $products = $this->createQueryBuilder("p")
                ->getQuery()
                ->getArrayResult();
            $result["isSuccess"] = true;
            $result["message"] = "Ürünler listelendi";
            $result["data"] = $products;
        } catch (\Exception $e) {
            $result["message"] = $e->getMessage();
        }
        return $result;
    }

    #[ArrayShape(["isSuccess" => "bool", "message" => "string", "data" => "mixed|null"])]
    public function updateProduct(Product $product,array $postData): array
    {
        $result = ["isSuccess" => false, "message" => "İşlem Yapılmadı", "data" => null];
        $product
            ->setProductName($postData["productName"]??$product->getProductName())
            ->setProductDescription((string)$postData["productDescription"]??$product->getProductDescription())
            ->setProductStock((int)$postData["productStock"]??$product->getProductStock())
            ->setProductPrice((float)$postData["productPrice"]??$product->getProductPrice());
        try {
            $this->addOrUpdate($product, true);
            $result["isSuccess"] = true;
            $result["message"] = "Ürün başarıyla güncellendi";
            $result["data"] = $product;
        } catch (\Exception $e) {
            $result["message"] = $e->getMessage();
        }
        return $result;

    }

}

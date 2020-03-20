<?php


namespace App\Controller;

use App\Core\AbstractController;
use App\Model\Product;
use App\Validator\ProductValidator;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RestController extends AbstractController
{
    private $jms;

    public function __construct()
    {
        $this->jms = SerializerBuilder::create()->build();
    }

    public function course()
    {
        return $this->render('rest/course.phtml');
    }

    public function index(Request $request)
    {
        switch($request->getMethod()) {
            case "GET":
                return $this->list();
                break;
            case "POST":
                return $this->add();
                break;
        }

        /**
         * 200 => OK
         * 404 => Not Found
         * 500 => Internal Server Error
         * 405 => Method Not Allowed
         */
        $data = [
            "code" => Response::HTTP_METHOD_NOT_ALLOWED,
            "message" => "Method Not Allowed"
        ];

        return new JsonResponse($data, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function show($id, Request $request)
    {
        if ("GET" === $request->getMethod()) {
            $repository = $this->getDoctrine()->getEntityManager()->getRepository(Product::class);
            $product = $repository->find($id);

            if (!$product) {
                $data = [
                    "code" => Response::HTTP_NOT_FOUND,
                    "message" => "Aucune ressource trouvé"
                ];

                return new JsonResponse($data, Response::HTTP_NOT_FOUND);
            }

            $json = $this->jms->serialize($product, 'json');

            return JsonResponse::fromJsonString($json);
        }

        $data = [
            "code" => Response::HTTP_METHOD_NOT_ALLOWED,
            "message" => "Method Not Allowed"
        ];

        return new JsonResponse($data, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    protected function list()
    {
        $repository = $this->getDoctrine()->getEntityManager()->getRepository(Product::class);
        $products = $repository->findAll();

        // $json = json_encode($products);
        $json = $this->jms->serialize($products, 'json');

        // type par défaut -> text/html text/plain
        // application/json
        return JsonResponse::fromJsonString($json);
    }

    protected function add()
    {
        $data = json_decode(file_get_contents("php://input"));
        //$product = $this->jms->deserialize($data, Product::class, 'json');

        $product = new Product();
        $product->setName($data->name ?? null);
        $product->setPrice($data->price ?? null);
        $product->setDescription($data->description ?? null);
        $product->setDate(($data->date != null) ? new \DateTime($data->date) : null);

        $errors = ProductValidator::validate($product);
        if( count($errors) > 0 ) {
            $data = [
                "code" => Response::HTTP_BAD_REQUEST,
                "message" => "Bad Request",
                "errors" => $errors
            ];

            return new JsonResponse($data);
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();

        $data = [
            "code" => Response::HTTP_CREATED,
            "message" => "Created",
            "ressource" => $this->jms->serialize($product, 'json') // ne pas retourner
        ];

        return new JsonResponse($data, Response::HTTP_CREATED);
    }
}
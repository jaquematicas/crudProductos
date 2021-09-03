<?php  

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{

      /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct( EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }


     /**
     * @Route("/", name="product_index", methods={"GET"})
     */
  public function index(ProductRepository $productRepository): Response
    {
      
    return $this->render('product/index.html.twig', [
            'product' => $productRepository->findAll(),
        ]);
    }
    
      /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
       public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->setCreatedAt(new \DateTime());
            $product->setUpdatedAt(new \DateTime());
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $product->setUpdatedAt(new \DateTime());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE", "GET"})
     */
    public function delete(Request $request, Product $product): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
     

        return $this->redirectToRoute('product_index');
    }

     private function getData(): array
    {

        /**
         * @var $product Product[]
         */


        $list = [];
        $product = $this->entityManager->getRepository(Product::class)->findAll();

        foreach ($product as $prod) {
            $list[] = [
                $prod->getcode(),
                $prod->getName(),
                $prod->getDescription(),
                $prod->getBrand(),
                $prod->getCategory()->getName(),
                $prod->getPrice()
            ];
        }

        return $list;
    }

     /**
     * @Route("export", name="export")
     */
    public function export()
    {

    
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Lista de Productos');

        $sheet->getCell('A1')->setValue('Código');
        $sheet->getCell('B1')->setValue('Nombre');
        $sheet->getCell('C1')->setValue('Descripción');
        $sheet->getCell('D1')->setValue('Marca');
        $sheet->getCell('E1')->setValue('Categoría');
        $sheet->getCell('F1')->setValue('Precio');

        // Increase row cursor after header write

        $list = $this->getData();


        $sheet->fromArray($list,null, 'A2', true);
        

        $writer = new Xlsx($spreadsheet);

      

        $fileName = 'productos.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

         $writer->save($temp_file);

        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

        
    }
}
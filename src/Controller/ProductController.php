<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductController extends AbstractController
{
    /**
     * Affiche et traite le formulaire d'ajout d'un produit
     * @Route("/produit/gestion/creation", methods={"GET", "POST"})
     * @param Request $requestHTTP
     * @return Response
     */
    public function create(Request $requestHTTP): Response
    {
        //Récupération du formulaire
        $product = new Product();
        $formProduct = $this->createForm(ProductType::class, $product);

        //On envoie les données postées au formulaire
        $formProduct->handleRequest($requestHTTP);

        //On vérifie que le formulaire est soumis et valide
        if ($formProduct->isSubmitted() && $formProduct->isValid()) {
            //On sauvegarde le pd en BDD grâce au manager
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();

            //Ajout d'un message flash
            $this->addFlash('success', 'le produit a bien été ajouté');


            //Redirection
            return $this->redirectToRoute('app_product_index');
        }

        /*
         * Récupération d'une catégorie
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find(1)
            ;
        //Création et remplissage du produit
        $product = new Product();
        $product
            ->setName('ventila')
            ->setDescription('Pour faire du froid')
            ->setImageName('ventilo.jpg')
            ->setEtatPublication(true)
            ->setPrice(15.99)
            ->setCategory($category)
            ;
        dump($product);
        */

        /* On sauvegarde le produit en BDD grâce au manager
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($product);
        $manager->flush();
        */

        return $this->render('product/create.html.twig', [
            'formProduct' => $formProduct->createView()
        ]);
    }

    /**
     * Affiche et traite le formulaire de modification d'un produit
     * @Route(
     *     "/produit/gestion/modification/{slug<[a-z0-9\-]+>}",
     *     methods={"GET", "POST"}, name="app_produit_modification"
     * )
     * @param Request $requestHTTP
     * @param UserInterface $user
     * @return Response
     */
    public function update(Request $requestHTTP, UserInterface $user): Response
    {
        if ($product->getPublisher() !== $user && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException("L'utilisateur courant ne peut modifier ce produit");
        }

        // Récupération du formulaire
        $formProduct = $this->createForm(ProductType::class, $product);

        // On envoie les données postées au formulaire
        $formProduct->handleRequest($requestHTTP);

        // On vérifie que le formulaire est soumis et valide
        if ($formProduct->isSubmitted() && $formProduct->isValid()) {
            //Permettre d'associer l'utilisateur connecté à la création d'un produit afin que
            //l'utilisateur puisse modifier son produit
            $product->setPublisher($user);

            // On sauvegarde le produit en BDD grâce au manager
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            // Ajout d'un message flash
            $this->addFlash('warning', 'Le produit a bien été modifié');

            // Redirection
            return $this->redirectToRoute('app_product_index');
        }
        return $this->render('product/update.html.twig', [
            'formProduct' => $formProduct->createView()
        ]);
    }

    /**
     * Suppression d'un produit
     * @Route("/produit/suppression/{slug<[a-z0-9\-]+>}", methods={"GET", "POST"}, name="app_produit_suppression")
     * @param Product $product
     * @return Response
     */
    public function delete(Product $product): Response
    {
        // On sauvegarde le produit en BDD grâce au manager
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($product);
        $manager->flush();
        // Ajout d'un message flash
        $this->addFlash('danger', 'Le produit est supprimé');
        return $this->redirectToRoute('app_product_index');
    }

    /**
     * Liste des produits
     * @Route("/produit/liste")
     * @return Response
     */
    public function index(): Response
    {
        // Récupération du Repository des produits
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);
        // Récupérations de tous les produits publiés
        $products = $repository->findBy([
            'etatPublication' => true
        ]);
        // Renvoi des produits à la vue
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * Affiche le détail d'un produit
     * @Route("/produit/{slug<[a-z0-9\-]+>}", methods={"GET", "POST"}, name="app_produit")
     * @param string $slug
     * @return Response
     * @throws \Exception
     */
    public function show(string $slug): Response
    {
        //throw new \Exception('Test Erreur 500');

        //Récupération du repository
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);
        //Récupération du produit lié au slug de l'URL
        $product = $repository->findOneBy([
            'slug' => $slug,
            'etatPublication' => true
        ]);
        //Si on n'a pas de produit -> erreur 404
        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé !');
        }
        //Renvoie du produit à la vue
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}

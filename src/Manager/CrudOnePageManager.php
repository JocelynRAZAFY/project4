<?php
/**
 * Created by PhpStorm.
 * User: jocelyn
 * Date: 5/12/19
 * Time: 11:26 AM
 */

namespace App\Manager;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CrudOnePageManager extends BaseManager
{
    /**
     * @var VilleRepository
     */
    private $villeRepository;

    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * CrudOnePageManager constructor.
     * @param EntityManagerInterface $em
     * @param ContainerInterface $container
     * @param RequestStack $requestStack
     * @param SessionInterface $session
     * @param LoggerInterface $logger
     * @param VilleRepository $villeRepository
     * @param ContactRepository $contactRepository
     */
    public function __construct(
        EntityManagerInterface $em,
        ContainerInterface $container,
        RequestStack $requestStack,
        SessionInterface $session,
        LoggerInterface $logger,
        VilleRepository $villeRepository,
        ContactRepository $contactRepository)
    {
        $this->villeRepository = $villeRepository;
        $this->contactRepository = $contactRepository;

        parent::__construct($em, $container, $requestStack, $session, $logger);
    }

    /**
     * Mise à jour de one page
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function updateOnePage()
    {
        $ville = $this->villeRepository->find((int)explode('-',$this->data->ville)[1]);
        if(empty($this->data->id)){
            $contact = new Contact();
            $contact->setCreated(new \DateTime());
            $type = 'add';
        }else{
            $type = 'edit';
            $contact = $this->contactRepository->find($this->data->id);
        }
        $contact->setLastName($this->data->lastName);
        $contact->setFirstName($this->data->firstName);
        $contact->setBirthDate(new \DateTime($this->data->birthDate));
        $contact->setVille($ville);
        $contact->setUpdated(new \DateTime());
        $this->save($contact);

        $result = [
            'type' => $type,
            'id' => $contact->getId(),
            'lastName' => $contact->getLastName(),
            'firstName' => $contact->getFirstName(),
            'birthDate' => $contact->getBirthDate()->format('d/m/Y'),
            'ville' => $contact->getVille()->getNomCommune(),
        ];
        return $this->success($result);
    }

    /**
     * listes des régions, départements, villes
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getRegionDepartementVille()
    {
        $results = $this->villeRepository->getRegionDepartementVille($this->data);

        return $this->success($results);
    }

    /**
     * Détail de contact sélectionné
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDetail()
    {
        $result = [];
        if(isset($this->data->idContact)){
            $contact = $this->contactRepository->find($this->data->idContact);
            $result = [
                'id' => $contact->getId(),
                'lastName' => $contact->getLastName(),
                'firstName' => $contact->getFirstName(),
                'birthDate' => $contact->getBirthDate()->format('Y-m-d'),
                'selectedRegion' => $contact->getVille()->getCodeRegion(),
                'region' => $this->villeRepository->getDistinctRegion(),
                'selectedDepartement' => $contact->getVille()->getNumeroDepartement(),
                'selectedVille' => $contact->getVille()->getId().'-'.$contact->getVille()->getCodeInsee(),
                'villeName' => $contact->getVille()->getNomCommune(),
            ];

            $param = new \stdClass();
            $param->type = 'departement';
            $param->code_region = $contact->getVille()->getCodeRegion();
            $result['departement'] = $this->villeRepository->getRegionDepartementVille($param);

            $param->type = 'ville';
            $param->code_region = $contact->getVille()->getCodeRegion();
            $param->numero_departement = $contact->getVille()->getNumeroDepartement();
            $result['ville'] = $this->villeRepository->getRegionDepartementVille($param);
        }

        return $this->success($result);
    }

    /**
     * Suppression
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteContact()
    {
        $contact = $this->contactRepository->find($this->data->idContact);
        $idContact = $contact->getId();
        $this->remove($contact);

        return $this->success(['idContact' => $idContact]);
    }
}
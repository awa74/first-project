<?php
	
	namespace App\Controller;
	
	use App\Entity\User;
	use ApiPlatform\Core\Api\IriConverterInterface;
	use App\Repository\UserRepository;
	use App\Repository\ProfilRepository;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\Request;
	use App\services\Userservice;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Serializer\SerializerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	use function gmdate;
	
	class UserController extends AbstractController
	{
	 /**
	 * @Route(
	 * name="create_user",
	 * path="api/admin/users",
	 * methods={"POST"},
	 * defaults={
	 * "_controller"="\app\Controller\UserController::create_user",
	 * "_api_resource_class"=User::class,
	 * "_api_collection_operation_name"="create_user"
	 * }
	 * )
	 */
	 
	 public function create_user(Userservice $userservice,Request $request, SerializerInterface $serialize,UserPasswordEncoderInterface $encoder,EntityManagerInterface $entity)
	 {
	 $user= $userservice->add($request,$profil=null);
	 //dd($user);
	 $entity -> persist($user);
	 $entity -> flush();
	 return $this->json("succes",201);
	 }
	
	 /**
	 * @Route(
	 * path="api/admin/users/{id}",
	 * name="putUserId",
	 * methods={"PUT"},
	 * defaults={
	 * "_api_resource_class"=User::class,
	 * "_api_item_operation_name"="putUserId"
	 * }
	 * )
	 * @param UserService $service
	 * @param Request $request
	 * @return JsonResponse
	 */
	 public function putUserId(IriConverterInterface $iriconverter, UserService $service, Request $request, ProfilRepository $prof,EntityManagerInterface $manager)
	 {
	 //dd($request);
	 $userUpdate = $service->PutUser($request,'avatar');
	 //dd($userUpdate);
	 $utilisateur = $request ->attributes->get('data');
	 //dd($userUpdate["profil"]);
	
	 //dd($utilisateur);
	 foreach ($userUpdate as $key=> $valeur){
	 $setter = 'set'. ucfirst(strtolower($key));
	 //dd($setter);
	 if(method_exists(User::class, $setter)){
	 if($setter=='setProfil'){
	 $profil = $iriconverter->getItemFromIri($userUpdate["profil"]);
	 //dd($profil);
	 $utilisateur->setProfil($profil);
	 $utilisateur->setDtype($profil->getLibelle());
	 //dd($utilisateur);
	 }
	 else{
	 $utilisateur->$setter($valeur);
	 }
	 }
	 if ($setter=='setPassword'){
	 $utilisateur->setPassword($this->encoder->encodePassword($utilisateur,$userUpdate['password']));
	
	 }
	 }
	 //dd($utilisateur);
	 $manager->persist($utilisateur);
	 $manager->flush();
	
	
	 return $this->json("succes",201);
	
	
	 }
	
	 /**
	 * @Route(
	 * name="archive_user",
	 * path="api/admin/users/{id}/archive",
	 * methods={"PUT"},
	 * defaults={
	 * "_controller"="\app\Controller\UserController::archive_user",
	 * "_api_resource_class"=User::class,
	 * "_api_item_operation_name"="archive_user"
	 * }
	 * )
	 */
	 public function archive_user(Request $request,EntityManagerInterface $entity,SerializerInterface $serialize,UserRepository $userrepo)
	 {
	 dd($request);
	 $User_json = $request->request->all();
	 dd($User_json);
	 $User = $serialize ->denormalize($User_json,"App\Entity\User",true);
	 $User->setArchive(1);
	 $entity -> persist($User);
	 $entity -> flush();
	 return $this->json("succes",201);
	 }
	
	}
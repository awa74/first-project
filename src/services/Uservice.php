<?php
	namespace App\services;
	
	use ApiPlatform\Core\Api\IriConverterInterface;
	use App\Repository\UserRepository;
	use Symfony\Component\HttpFoundation\Request;
	use App\Repository\ProfilRepository;
	use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
	use Symfony\Component\Serializer\SerializerInterface;
	use Symfony\Component\Validator\Validator\ValidatorInterface;
	use function dd;
	use function json_decode;
	
	class Userservice
	{
	 private $_iriconverter;
	 private $_serializer;
	 private $_encoder;
	 private $repoProfil;
	 public function __construct(
	 IriConverterInterface $_iriconverter,
	 SerializerInterface $_serializer,
	 UserPasswordEncoderInterface $_encoder,
	 ProfilRepository $repoProfil,
	 ValidatorInterface $validator)
	 {
	 $this->_iriconverter = $_iriconverter;
	 $this->_serializer = $_serializer;
	 $this->_encoder = $_encoder;
	 $this->repoProfil=$repoProfil;
	 $this->validator =$validator;
	 }
	 public function uploadimage(Request $request)
	 {
	 $image = $request->files->get("avatar");
	 $image = fopen($image->getRealPath(),"rb");
	 //fclose($image);
	
	 return $image;
	 }
	 /**
	 * put image of user
	 * @param Request $request
	 * @param string|null $fileName
	 * @return array
	 */
	 public function PutUser(Request $request,string $fileName = null){
	 $raw =$request->getContent();
	
	 // dd($raw);
	 //dd($request->headers->get("content-type"));
	 $delimiteur = "multipart/form-data; boundary=";
	 $boundary= "--" . explode($delimiteur,$request->headers->get("content-type"))[1];
	 $elements = str_replace([$boundary,'Content-Disposition: form-data;',"name="],"",$raw);
	 //dd($elements);
	 $elementsTab = explode("\r\n\r\n",$elements);
	 //dd($elementsTab);
	 $data =[];
	 for ($i=0;isset($elementsTab[$i+1]);$i+=2){
	 //dd($elementsTab[$i+1]);
	 $key = str_replace(["\r\n",' "','"'],'',$elementsTab[$i]);
	 //dd($key);
	 if (strchr($key,$fileName)){
	 $stream =fopen('php://memory','r+');
	 //dd($stream);
	 fwrite($stream,$elementsTab[$i +1]);
	 rewind($stream);
	 $data[$fileName] = $stream;
	 //dd($data);
	 }else{
	 $val=$elementsTab[$i+1];
	 //$val = str_replace(["\r\n", "--"],'',base64_encode($elementsTab[$i+1]));
	 //dd($val);
	 $data[$key] = $val;
	 // dd($data[$key]);
	 }
	 }
	 //dd($data);
	 //$prof=$this->ProfilRepository->findOneBy(['libelle'=>$data["profil"]]);
	 //$data["profil"] = $prof;
	 //dd($data);
	 return $data;
	
	 }
	 public function add ($request, $profil=null)
	 {
	 //dd($request);
	 //$user_data=json_decode($request->getContent(), true) ;
	 $user_data=$request->request->all();
	 dd($user_data['profil']);
	 $profil = $this->_iriconverter->getItemFromIri($user_data['profil']);
	 //dd($profil);
	 $user= $this->_serializer->denormalize($user_data,"App\Entity\\Apprenant",true);
	 $avatar=$request->files->get("avatar");
	 if($avatar)
	 {
	 $avatarBlob=fopen($avatar->getRealPath(),"rb");
	 $user->setAvatar($avatarBlob);
	 }
	
	
	 $errors = $this->validator->validate($user);
	 if(count($errors)){
	 $errors = $this->serializer->serialize($errors,"json");
	 return['error'=>$errors];
	 }
	 $user -> SetPassword($this->_encoder->encodePassword($user, 'passer'));
	 $user->SetArchivage(false);
	 return $user;
	 }
	}
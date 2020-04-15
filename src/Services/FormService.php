<?php

namespace App\Services;

use App\Entity\Advertiser;
use App\Entity\Association;
use App\Entity\Award;
use App\Entity\BlogPost;
use App\Entity\Builder;
use App\Entity\Category;
use App\Entity\Company;
use App\Entity\CompanyService;
use App\Entity\Education;
use App\Entity\EntityImage;
use App\Entity\Experience;
use App\Entity\Firm;
use App\Entity\OpenBid;
use App\Entity\Order;
use App\Entity\Post;
use App\Entity\PostComment;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\Project;
use App\Entity\ProjectComment;
use App\Entity\Property;
use App\Entity\QuotationRequest;
use App\Entity\RentalRequest;
use App\Entity\Specialty;
use App\Entity\StatusPost;
use App\Entity\Supplier;
use App\Entity\TopSupplier;
use App\Entity\Town;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Entity\WeeklyDeal;
use App\Entity\Work;
use App\Form\AdvertiserType;
use App\Form\AssociationType;
use App\Form\AwardType;
use App\Form\BuilderRegistrationType;
use App\Form\BuilderType;
use App\Form\CompanyServiceType;
use App\Form\EducationType;
use App\Form\EntityImageType;
use App\Form\ExperienceType;
use App\Form\FirmType;
use App\Form\Inventory\RentalRequestType;
use App\Form\OpenBidType;
use App\Form\OrderType;
use App\Form\PostCommentType;
use App\Form\PostType;
use App\Form\ProductCategoryType;
use App\Form\ProductType;
use App\Form\ProfileType;
use App\Form\ProjectCommentType;
use App\Form\ProjectType;
use App\Form\PropertyType;
use App\Form\QuotationRequestType;
use App\Form\SpecialtyType;
use App\Form\StatusPostType;
use App\Form\SupplierType;
use App\Form\TopSupplierType;
use App\Form\Type\PropertyFilterType;
use App\Form\Type\StoreLocationFilterType;
use App\Form\UserType;
use App\Form\WeeklyDealType;
use App\Form\WorkType;
use App\Repository\ProductCategoryRepository;
use App\Utils\Constants;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Role\Role;

class FormService extends BaseFormService {

    //##################################### Start User Registration Related Forms ####################    
    public function createBuilderForm(Builder $artisan = null) {
        if ($artisan == null) {
            $artisan = new Builder();
        }
        $form = $this->createForm(BuilderType::class, $artisan);
        return $form;
    }

    public function createBuilderRegistrationForm(User $user = null) {
        if ($user == null) {
            $user = new User();
        }
        $form = $this->createForm(BuilderRegistrationType::class, $user);
        return $form;
    }

    public function createUserForm(User $user = null) {
        if ($user == null) {
            $user = new User();
        }
        $form = $this->createForm(UserType::class, $user);
        return $form;
    }

    

//####################### End Security Related Forms ###################################
//########################## Start Store Related Forms ################################
    public function createProductCategoryForm($category = null) {
        if ($category == null) {
            $category = new ProductCategory();
            //$category->setDisplayed(true);
            $category->setCount(0);
        }
        $form = $this->createForm(ProductCategoryType::class, $category);
        return $form;
    }

    public function createProductForm($product = null, $vendor = null) {
        if ($product == null) {
            $product = new Product();
            $product->setEnabled(false);
        }
        $form = $this->createForm(ProductType::class, $product, ['vendor' => $vendor]);
        return $form;
    }

    public function createQuotationForm(Supplier $supplier) {
        $order = new Order();
        return $this->createForm(OrderType::class, $order, array('supplier' => $supplier));
    }

//########################## End Store Related Forms ################################
//########################## Start Company Related Forms ################################
    public function createFirmForm(Firm $firm = null) {
        if ($firm == null) {
            $firm = new Firm();
        }
        $form = $this->createForm(FirmType::class, $firm);
        return $form;
    }

    public function createSupplierForm(Supplier $supplier = null) {
        if ($supplier == null) {
            $supplier = new Supplier();
        }
        $form = $this->createForm(SupplierType::class, $supplier);
        return $form;
    }

    public function createAdvertiserForm(Advertiser $advertiser = null) {
        if ($advertiser == null) {
            $advertiser = new Advertiser();
        }
        $form = $this->createForm(AdvertiserType::class, $advertiser);
        return $form;
    }

    public function createCompanyForm(Company $company = null) {
        if ($company instanceof Supplier) {
            $form = $this->createSupplierForm($company);
        } else if ($company instanceof Firm) {
            $form = $this->createFirmForm($company);
        } else if ($company instanceof Advertiser) {
            $form = $this->createAdvertiserForm($company);
        } else {
            $form = $this->createFirmForm($company);
        }
        return $form;
    }

//########################## End Company Related Forms ##################################
//########################## Start Store Backend Forms ##################################
    public function createTopSupplierForm(TopSupplier $topSupplier = null) {
        if ($topSupplier == null) {
            $topSupplier = new TopSupplier();
        }
        $form = $this->createForm(TopSupplierType::class, $topSupplier);
        return $form;
    }

    public function createWeeklyDealForm(WeeklyDeal $weeklyDeal = null, $supplier = null) {
        if ($weeklyDeal == null) {
            $weeklyDeal = new WeeklyDeal();
        }
        $form = $this->createForm(WeeklyDealType::class, $weeklyDeal, ['supplier' => $supplier]);
        return $form;
    }

//########################## End Store Backend Forms ####################################
//########################## Start Estates  Forms ####################################
    public function createPropertyForm(Property $property = null) {
        if ($property == null) {
            $property = new Property();
        }
        $form = $this->createForm(PropertyType::class, $property);
        return $form;
    }

    public function createPropertyFilterForm() {
        $form = $this->createForm(PropertyFilterType::class, new Property());
        return $form;
    }

//########################## End Estates  Forms  ####################################
//######################### Start User Profile Forms ############################
    public function createProfileForm(User $user) {
        $profile = $user->getUserProfile();
        if ($profile == null) {
            $profile = new UserProfile($user);
        }
        $form = $this->createForm(ProfileType::class, $profile);
        return $form;
    }

    public function createSpecialtyForm(Specialty $specialty = null) {
        if ($specialty == null) {
            $specialty = new Specialty();
        }
        $form = $this->createForm(SpecialtyType::class, $specialty);
        return $form;
    }

    public function createAccountActivationForm(User $user, $type = null) {
        $defaultData = array('phone' => $user->getContactNo(), 'mode' => $type);
        $form = $this->createFormBuilder($defaultData)
                ->add('phone', TextType::class, array(
                    'required' => true
                ))
                ->add('code', TextType::class, array(
                    'required' => false
                ))
                ->add('mode', ChoiceType::class, array(
                    'required' => true,
                    'choices' => array(
                        'Email' => 'email',
                        'SMS Code' => 'sms'
                    ),
                    'expanded' => true,
                    'multiple' => false
                ))
                ->add('sendSMS', SubmitType::class, array('label' => 'Send SMS'))
                ->add('activateAccount', SubmitType::class, array('label' => 'Activate Account'))
                ->getForm();
        return $form;
    }

    public function createInvitationForm() {
        $defaultData = array('email' => "");
        $form = $this->createFormBuilder($defaultData)
                ->add('email', EmailType::class, array('required' => TRUE))
                ->add('email1', EmailType::class, array('required' => FALSE))
                ->add('email2', EmailType::class, array('required' => FALSE))
                ->add('email3', EmailType::class, array('required' => FALSE))
                ->add('email4', EmailType::class, array('required' => FALSE))
                ->getForm();
        return $form;
    }

    public function createInvitationResponseForm($email = null) {
        $defaultData = array('email' => $email);
        $form = $this->createFormBuilder($defaultData)
                ->add('firstname', TextType::class, array('required' => true))
                ->add('lastname', TextType::class, array('required' => true))
                ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                ))
                ->add('email', EmailType::class, array('required' => TRUE))
                ->add('profile', TextareaType::class, array('required' => FALSE))
                ->add('agreeTerms', CheckboxType::class, array('required' => TRUE))
                ->getForm();
        return $form;
    }

    public function createWorkForm(Work $work = null) {
        if ($work == null) {
            $work = new Work();
        }
        $form = $this->createForm(WorkType::class, $work);
        return $form;
    }

    //Form that Adds photos to project or works
    public function createPhotoForm(EntityImage $image = null) {
        if ($image == null) {
            $image = new EntityImage();
        }
        $form = $this->createForm(EntityImageType::class, $image);
        return $form;
    }

    public function createExperienceForm(Experience $experience = null) {
        if ($experience == null) {
            $experience = new Experience();
        }
        $form = $this->createForm(ExperienceType::class, $experience);
        return $form;
    }

    

    public function createEducationForm($education = null) {
        if ($education == null) {
            $education = new Education();
        }
        $form = $this->createForm(EducationType::class, $education);
        return $form;
    }

    public function createAwardForm(Award $award = null) {
        if ($award == null) {
            $award = new Award();
        }
        $form = $this->createForm(AwardType::class, $award);
        return $form;
    }

    public function createAssociationForm(Association $association = null) {
        if ($association == null) {
            $association = new Association();
        }
        $form = $this->createForm(AssociationType::class, $association);
        return $form;
    }

//######################### End User Profile Forms ############################
    //######################### Start Builders Engage Forms ############################
    /**
     * 
     * @param SnapShare $snapShare
     * @return type
     */
    public function createSnapshareForm(SnapShare $snapShare = null) {
        if ($snapShare == null) {
            $snapShare = new SnapShare();
        }
        $form = $this->createForm(SnapShareType::class, $snapShare);
        return $form;
    }

    public function createSnapshareCommentFrom($snapshare) {
        $snapshareComment = new SnapshareComment($snapshare);
        $form = $this->createForm(SnapshareCommentType::class, $snapshareComment);
        return $form;
    }

    public function createConversationForm(Conversation $conversation = null) {
        if ($conversation == null) {
            $conversation = new Conversation();
        }
        return $this->createForm(ConversationType::class, $conversation);
    }

    public function createPostForm(Post $post = null) {
        if ($post == null) {
            $post = new BlogPost();
        }
        return $this->createForm(PostType::class, $post);
    }

    public function createStatusForm(Post $post = null) {
        if ($post == null) {
            $post = new StatusPost();
        }
        return $this->createForm(StatusPostType::class, $post);
    }

    public function createPostCommentForm(Post $post, PostComment $postComment = null) {
        if ($postComment == null) {
            $postComment = new PostComment($post);
        }
        return $this->createForm(PostCommentType::class, $postComment);
    }

    public function createProjectForm(Project $project = null) {
        if ($project == null) {
            $project = new Project($project);
        }
        return $this->createForm(ProjectType::class, $project);
    }

    public function createProjectCommentForm(Work $project, ProjectComment $comment = null) {
        if ($comment == null) {
            $comment = new ProjectComment($project);
        }
        return $this->createForm(ProjectCommentType::class, $comment);
    }

    

    public function createMQRForm(QuotationRequest $quotationRequest = null) {
        if ($quotationRequest == null) {
            $quotationRequest = new QuotationRequest();
        }
        return $this->createForm(QuotationRequestType::class, $quotationRequest);
    }

    public function createProjectFilterForm() {
        $project = new Project();
        $form = $this->createForm(ProjectFilterType::class, $project);
        return $form;
    }

    //#################### BuildersHub Setup Forms ##########################
    public function createTownForm(Town $town = null) {
        if ($town == null) {
            $town = new Town();
        }
        $form = $this->createForm(TownType::class, $town);
        return $form;
    }

    public function createRoleForm(Role $role = null) {
        if ($role == null) {
            $role = new Role();
        }
        $form = $this->createForm(RoleType::class, $role);
        return $form;
    }

    public function createWorkCategoryForm(Category $category = null) {
        if ($category == null) {
            $category = new Category();
        }
        return $this->createForm(CategoryType::class, $category);
    }

    public function createTenderForm(Tender $tender = null) {
        if ($tender == null) {
            $tender = new Tender();
        }
        return $this->createForm(TenderType::class, $tender);
    }

    //------------------------------- End Setup Forms ----------------------

    public function createRequestForm() {
        $form = $this->createFormBuilder([])
                ->add('requestType', ChoiceType::class, array(
                    'choices' => [
                        'Request for Proposal' => 'Request for Proposal',
                        'Undertake a Project' => 'Undertake a Project',
                        'Price Quotation Request' => 'Price Quotation Request',
                        'Technical Advice' => 'Technical Advice',
                        'Other Request' => 'Other Request',
                    ],
                    'required' => true,
                    'placeholder' => 'Select request type'
                ))
                ->add('request', TextareaType::class, array(
                ))
                ->getForm();
        return $form;
    }

    public function createUserTypeForm() {
        $form = $this->createFormBuilder([])
                ->add('userType', ChoiceType::class, array(
                    'choices' => [
                        'Artisan/Tradeperson' => Constants::ARTISAN,
                        'Professional' => Constants::PROFESSIONAL,
                        'Student' => Constants::STUDENT,
                        'Firm/Company Owner (Construction/Consulting Firm, Advertiser )' => Constants::FIRM_OWNER,
                        'Supplier (Construction Materials/Equipment or Spare Parts)' => Constants::MERCHANT,
                        'Property Owner / Public User' => Constants::PUBLIC_USER,
                    ],
                    'required' => true,
                    'data' => null,
                    'placeholder' => 'Change user type'
                ))
                ->getForm();
        return $form;
    }

    public function createArtisanFilterForm($category = null, $town = null) {
        $defaultData = array('category' => 'Select Trade category', 'town' => 'Select Location of Work');
        $form = $this->createFormBuilder($defaultData)
                ->add('category', EntityType::class, array(
                    'required' => true,
                    'class' => Category::class,
                    //'attr' => ['data-select' => 'true'],
                    'data' => $category,
                ))
                ->add('town', TextType::class, array(
                    'required' => true,
                    'data' => $town
                ))
                ->getForm();
        return $form;
    }

    public function createLocationFilter($region = null, $town = null, $category = null) {
        $supplier = new Supplier();
        $supplier->setRegion($region);
        $supplier->setBusinessLocation($town);
        $form = $this->createForm(StoreLocationFilterType::class, $supplier, ['category' => $category]);
        return $form;
    }

    public function createCategoryStoreProductFilterForm($category = null) {
        $defaultData = array('productCategory' => 'Select Product Category');
        $form = $this->createFormBuilder($defaultData)
                ->add('productCategory', EntityType::class, array(
                    'required' => true,
                    'query_builder' => function(ProductCategoryRepository $pcr ) use ($category) {
                        return $pcr->findProductSubCategoriesQry(null, $category);
                    },
                    'class' => ProductCategory::class,
                    'attr' => ['data-select' => 'true'],
                    'placeholder' => 'Select Product Category'
                ))
                ->getForm();
        return $form;
    }

    public function createFeedbackForm(User $user = null) {
        $defaultData = array('message' => '');
        $form = $this->createFormBuilder($defaultData)
                ->add('email', EmailType::class, array(
                    'data' => $user != null ? $user->getEmail() : '',
                    'required' => true))
                ->add('message', TextareaType::class, array(
                    'required' => true,
                    'empty_data' => 'Please write your feedback here...'
                ))
                ->add('email_address', HiddenType::class, array(
                    'required' => false,
                ))
                ->getForm();

        return $form;
    }

    public function createSearchForm() {
        $defaultData = array('message' => '');
        $form = $this->createFormBuilder($defaultData)
                ->add('searchTerm', TextType::class, array(
                    'required' => true))
                ->getForm();
        return $form;
    }

    public function createEmptyForm() {
        $defaultData = array('message' => '');
        $form = $this->createFormBuilder($defaultData)
                ->add('input', TextType::class)
                ->getForm();
        return $form;
    }
//############################# START EQUIPMENT  RENTAL RELATED FORMS ##############################
    public function createRentalAdForm($ad = null) {
        if ($ad == null) {
            $ad = new RentalAdverts();
        }
        $form = $this->createForm(RentalAdvertType::class, $ad);
        return $form;
    }

    public function createRentalRequestForm($rentalRequest = null, User $user = null) {
        if ($rentalRequest == null) {
            $rentalRequest = new RentalRequest();
        }
        $form = $this->createForm(RentalRequestType::class, $rentalRequest, ['user' => $user]);
        return $form;
    }
    
//################################ END RENTAL RELATED FORMS #######################################
    public function createBidForm($openBid = null) {
        if ($openBid == null) {
            $openBid = new OpenBid();
        }

        $form = $this->createForm(OpenBidType::class, $openBid);
        return $form;
    }

    /**
     * Creates and returns form interface that allows a firm add what it does
     * @param CompanyService $companyService
     * @return FormInterface
     */
    public function createCompanyServiceForm(Company $company, CompanyService $companyService = null) {
        if ($companyService == null) {
            $companyService = new CompanyService($company);
        }

        $form = $this->createForm(CompanyServiceType::class, $companyService);
        return $form;
    }

}

<?php

// src/App/Entity/Post.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Base\BaseModel as Model;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**

 * @author Balika Edmon Mwinbamon <balikaem@gmail.com>
 *
 * @ORM\Table(name="post")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="post_type", type="string")
 * @ORM\DiscriminatorMap({"blog" = "BlogPost","status" = "StatusPost", "snapshare"="Snapshare"})
 */
abstract class Post extends Model implements \App\Model\PostInterface {

    const BLOG = 'blog';
    const STATUS = 'status';
    const SNAPSHARE = 'snapshare';

    /**
     * @ORM\Column(type="string")
     * 
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $excerpt;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\Column(type="string")
     */
    protected $status;

    /**
     * @ORM\Column(type="string")
     */
    protected $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isCommentable;

    /**
     * @ORM\Column(type="integer")
     */
    protected $commentCount;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isPublished;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $publishDate;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="uploaded_photo", fileNameProperty="featureImage")
     * 
     * @var File
     */
    protected $imageFile;

    /**
     * @var string $featureImage
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    protected $featureImage;
    //#################### Relations with other entites #########################
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * 
     */
    protected $user;
    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="posts")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * 
     */
    protected $company;
    

    /**
     *
     *   @ORM\ManyToMany(targetEntity="PostCategory")
     *   @ORM\JoinTable(name="post_category_relationship",
     *   joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     * */
    protected $postCategories;

    /**
     *
     *   @ORM\ManyToMany(targetEntity="PostCategory")
     *   @ORM\JoinTable(name="post_category_relationship",
     *   joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     * */
    protected $postTags;

    /**
     * @ORM\OneToMany(
     *      targetEntity="PostComment",
     *      mappedBy="post", 
     *      cascade={"persist"}       
     * )
     * 
     */
    protected $comments;

    /**
     *
     *   @ORM\ManyToMany(targetEntity="User")
     *   @ORM\JoinTable(name="post_like",
     *   joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")})
     * */
    protected $likes;

    public function getTitle() {
        return $this->title;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image
     *
     * @return Person
     */
    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->createdAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile() {
        return $this->imageFile;
    }

    public function getExcerpt() {
        return $this->excerpt;
    }

    public function getContent() {
        return $this->content;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getIsCommentable() {
        return $this->isCommentable;
    }

    public function getIsPublished() {
        return $this->isPublished;
    }

    public function getPublishDate() {
        return $this->publishDate;
    }

    public function getFeatureImage() {
        return $this->featureImage;
    }

    public function getUser() {
        return $this->user;
    }

    public function setExcerpt($excerpt) {
        $this->excerpt = $excerpt;
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }

    public function setIsCommentable($isCommentable) {
        $this->isCommentable = $isCommentable;
        return $this;
    }

    public function setIsPublished($isPublished) {
        $this->isPublished = $isPublished;
        return $this;
    }

    public function setPublishDate($publishDate) {
        $this->publishDate = $publishDate;
        return $this;
    }

    public function setFeatureImage($featureImage) {
        $this->featureImage = $featureImage;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function getCommentCount() {
        return $this->commentCount;
    }

    public function setCommentCount($commentCount = 0) {
        $this->commentCount = $commentCount;
        return $this;
    }

    /**
     * Add postCategory
     *
     * @param PostCategory $postCategory
     *
     * @return Post
     */
    public function addCategory(PostCategory $postCategory) {
        if (!in_array($postCategory, $this->postCategories, TRUE)) {
            $this->postCategories[] = $postCategory;
        }

        return $this;
    }

    /**
     * Remove $postCategory
     *
     * @param PostCategory $postCategory
     */
    public function removeCategory(PostCategory $postCategory) {
        $this->postCategories->removeElement($postCategory);
    }

    public function setPostCategories($postCategories) {
        foreach ($postCategories as $postCategory) {
            $this->addCategory($postCategory);
        }
        return $this;
    }

    /**
     * Get postCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostCategories() {
        return $this->postCategories;
    }

    /**
     * Add postTag
     *
     * @param PostCategory $postTag
     *
     * @return Post
     */
    public function addTag(PostCategory $postTag) {
        if (!in_array($postTag, $this->postTags, TRUE)) {
            $this->postTags[] = $postTag;
        }
        return $this;
    }

    /**
     * Remove $postTags
     *
     * @param PostCategory $postTag
     */
    public function removePostTag(PostCategory $postTag) {
        $this->postTags->removeElement($postTag);
    }

    public function setPostTags($postTags) {
        foreach ($postTags as $postTag) {
            $this->addTag($postTag);
        }
        return $this;
    }

    /**
     * Get postTags
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostTags() {
        return $this->postTags;
    }

    public function setTitle($title = null) {
        $this->title = $title;
        return $this;
    }

    /**
     * Add comment
     *
     * @param PostComment $comment
     *
     * @return Post
     */
    public function addComment(PostComment $comment) {
        $this->comments[] = $comment;
        $comment->setPost($this);
        return $this;
    }

    /**
     * Remove comment
     *
     * @param PostComment $comment
     */
    public function removeComment(PostComment $comment) {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * Add like
     *
     * @param User $like
     *
     * @return Work
     */
    public function addLike(User $like) {
        $this->likes[] = $like;

        return $this;
    }

    /**
     * Remove like
     *
     * @param User $like
     */
    public function removeLike(User $like) {
        $this->likes->removeElement($like);
    }

    public function getLikes() {
        return $this->likes;
    }

    public function getFileName() {
        return 'post_featured_photo_' . \App\Utils\HubUtil::generateRandomString();
    }
    public function getCompany() {
        return $this->company;
    }
    public function setCompany(Company $company=null) {
        $this->company = $company;
        return $this;
    }



}

<?php

namespace Demo\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Advert
 *
 * @ORM\Table(name="demo_advert")
 * @ORM\Entity(repositoryClass="Demo\PlatformBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{
    
    /**
     *  @ORM\OneToMany(targetEntity="Demo\PlatformBundle\Entity\Application", mappedBy="advert")
     */
     // Relation bidirectionnelle : Mapped by => champ de l'entité inverse dans l'entité proprietaire => private $advert de Application
    private $applications; // "s" car plusieurs candidatures possibles
    
    // @ORM\JoinTable(name="nomPeuImporte_advert_category") -> Change le nom de la table de jointure
    /**
     * @ORM\ManyToMany(targetEntity="Demo\PlatformBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="demo_advert_category")
     */ 
    private $categories; 
    
    /**
    * @ORM\OneToOne(targetEntity="Demo\PlatformBundle\Entity\Image", cascade={"persist"})
    */
    private $image;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(name="published", type="boolean")
     */
  private $published = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;
    
    /**
     * @ORM\Column(name="nb_application", type="integer")
     */
     private $nbApplication = 0;
    
    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;
    
    // Constructeur de l'objet
    public function __construct(){
        // Par défaut, la date de l'annonce est la date d'aujourd'hui
        $this->date = new \DateTime();
        $this->categories = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Advert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Advert
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set image
     *
     * @param \Demo\Platformbundle\Entity\Image $image
     *
     * @return Advert
     */
    public function setImage(\Demo\Platformbundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Demo\Platformbundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add category
     *
     * @param \Demo\PlatformBundle\Entity\Category $category
     *
     * @return Advert
     */
    public function addCategory(\Demo\PlatformBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Demo\PlatformBundle\Entity\Category $category
     */
    public function removeCategory(\Demo\PlatformBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add application
     *
     * @param \Demo\PlatformBundle\Entity\Application $application
     *
     * @return Advert
     */
    public function addApplication(\Demo\PlatformBundle\Entity\Application $application)
    {
        $this->applications[] = $application;

        // Liaison de l'annonce a la candidature (car on ajoute une candidature a une annonce, mais l'annonce n'est toujours pas liée a la candidature)
        $application->setAdvert($this);

        return $this;
    }

    /**
     * Remove application
     *
     * @param \Demo\PlatformBundle\Entity\Application $application
     */
    public function removeApplication(\Demo\PlatformBundle\Entity\Application $application)
    {
        $this->applications->removeElement($application);
        
        // Et si notre relation était facultative (nullable=true, ce qui n'est pas notre cas ici attention) :        
        // $application->setAdvert(null);
    
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Advert
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function updateDate(){
        $this->setUpdatedAt(new \DateTime());
    }
    
    public function increaseApplication(){
        $this->nbApplication++;
    }
    
    public function decreaseApplication(){
        $this->nbApplication--;
    }

    /**
     * Set nbApplication
     *
     * @param integer $nbApplication
     *
     * @return Advert
     */
    public function setNbApplication($nbApplication)
    {
        $this->nbApplication = $nbApplication;

        return $this;
    }

    /**
     * Get nbApplication
     *
     * @return integer
     */
    public function getNbApplication()
    {
        return $this->nbApplication;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Advert
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Advert
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}

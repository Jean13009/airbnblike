<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
* @ORM\HasLifecycleCallbacks
*/
class Message
{
    /**
    * @ORM\Id()
    * @ORM\GeneratedValue()
    * @ORM\Column(type="integer")
    */
    private $id;
    
    /**
    * @ORM\Column(type="datetime")
    */
    private $createdAt;
    
    /**
    * @ORM\Column(type="text")
    */
    private $contenu;
    
    /**
    * @ORM\Column(type="boolean", nullable=true)
    */
    private $supParExp;
    
    /**
    * @ORM\Column(type="boolean", nullable=true)
    */
    private $supParDest;
    
    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messages")
    */
    private $User;
    
    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messagesrecus")
    */
    private $messagesRecus;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $lu;
    
    /**
    * Undocumented function
    *@ORM\PrePersist
    
    * @return void
    */
    public function prePersist() {
        if(empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    public function getContenu(): ?string
    {
        return $this->contenu;
    }
    
    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;
        
        return $this;
    }
    
    public function getSupParExp(): ?bool
    {
        return $this->supParExp;
    }
    
    public function setSupParExp(?bool $supParExp): self
    {
        $this->supParExp = $supParExp;
        
        return $this;
    }
    
    public function getSupParDest(): ?bool
    {
        return $this->supParDest;
    }
    
    public function setSupParDest(?bool $supParDest): self
    {
        $this->supParDest = $supParDest;
        
        return $this;
    }
    
    public function getUser(): ?User
    {
        return $this->User;
    }
    
    public function setUser(?User $User): self
    {
        $this->User = $User;
        
        return $this;
    }
    
    public function getMessagesRecus(): ?User
    {
        return $this->messagesRecus;
    }
    
    public function setMessagesRecus(?User $messagesRecus): self
    {
        $this->messagesRecus = $messagesRecus;
        
        return $this;
    }

    public function getLu(): ?bool
    {
        return $this->lu;
    }

    public function setLu(?bool $lu): self
    {
        $this->lu = $lu;

        return $this;
    }
}

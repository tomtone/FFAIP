<?php
namespace AppBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

class Customer implements UserInterface, EquatableInterface
{
    /**
     * @var array
     */
    protected $roles = ['ROLE_USER'];
    
    /**
     * @var
     */
    private $username;

    private $firstname;
    private $lastname;
    private $group_id;
    private $id;
    private $created_at;
    private $updated_at;
    private $created_id;
    private $email;
    private $store_id;
    private $website_id;
    private $address;
    private $disable_auto_group_change;
    private $bearerToken;

    /**
     * Customer constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        if(is_array($data)) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
            $this->username = $data['firstname'] . " " . $data['lastname'];
        }else {
            $this->username = $data;
        }
    }

    public function getData()
    {
        $class_vars = get_class_vars(self::class);
        $data = [];
        foreach ($class_vars as $name => $value) {
            $data[$name] = $value;
        }
        return $data;
    }

    public function isEqualTo(UserInterface $user)
    {
        if ($this->username !== $user->getUsername()) {
            return false;
        }
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return '';
    }

    public function getSalt()
    {
        return '';
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return mixed
     */
    public function getDisableAutoGroupChange()
    {
        return $this->disable_auto_group_change;
    }

    /**
     * @param mixed $disable_auto_group_change
     */
    public function setDisableAutoGroupChange($disable_auto_group_change)
    {
        $this->disable_auto_group_change = $disable_auto_group_change;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @param mixed $group_id
     */
    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedId()
    {
        return $this->created_id;
    }

    /**
     * @param mixed $created_id
     */
    public function setCreatedId($created_id)
    {
        $this->created_id = $created_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->store_id;
    }

    /**
     * @param mixed $store_id
     */
    public function setStoreId($store_id)
    {
        $this->store_id = $store_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWebsiteId()
    {
        return $this->website_id;
    }

    /**
     * @param mixed $website_id
     */
    public function setWebsiteId($website_id)
    {
        $this->website_id = $website_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBearerToken()
    {
        return $this->bearerToken;
    }

    /**
     * @param mixed $bearerToken
     */
    public function setBearerToken($bearerToken)
    {
        $this->bearerToken = $bearerToken;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->firstname . " " . $this->lastname;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->__toString(),
            $this->email,
        ]);
    }
}
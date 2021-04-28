<?php
declare(strict_types=1);

namespace AuthFernet\Entity;

/**
 * @Entity
 * @InheritanceType("SINGLE_TABLE")
 */
class User
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    public ?int $id;
    /** @Column */
    public string $username = '';
    /** @Column */
    public string $passwordHash;
    /** @Column */
    public string $roles;

    public function clean()
    {
        $this->passwordHash = '';
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }
}

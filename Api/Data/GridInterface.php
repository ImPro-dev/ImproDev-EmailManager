<?php
/**
 * ImproDev_EmailManager Grid Interface.
 *
 * @author ImpproDev
 */

namespace ImproDev\EmailManager\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array.
     */
    const ENTITY_ID = 'entity_id';
    const NAME = 'name';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const MESSAGE = 'message';
    const STATUS = 'status';

    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Set EntityId.
     */
    public function setEntityId($entityId);

    /**
     * Get Name.
     *
     * @return varchar
     */
    public function getName();

    /**
     * Set Name.
     */
    public function setName($name);

    /**
     * Get Email.
     *
     * @return varchar
     */
    public function getEmail();

    /**
     * Set Email.
     */
    public function setEmail($email);

    /**
     * Get Phone.
     *
     * @return varchar
     */
    public function getPhone();

    /**
     * Set Phone.
     */
    public function setPhone($phone);

    /**
     * Get Message.
     *
     * @return text
     */
    public function getMessage();

    /**
     * Set Message.
     */
    public function setMessage($message);

    /**
     * Get Status.
     *
     * @return varchar
     */
    public function getStatus();

    /**
     * Set Status.
     */
    public function setStatus($status);

}
<?php

namespace Biplane\YandexDirect\Api\V5\Contract;

/**
 * Auto-generated code.
 */
class RetargetingListAddItem
{

//    Can be omit.
//    protected $Type = null;

    protected $Name = null;

//    Can be omit.
//    protected $Description = null;

    protected $Rules = [];

    /**
     * Creates a new instance of RetargetingListAddItem.
     *
     * @return self
     */
    public static function create()
    {
        return new self();
    }

    /**
     * Gets Type.
     *
     * @return string|null
     * @see RetargetingListTypeEnum
     */
    public function getType()
    {
        return isset($this->Type) ? $this->Type : null;
    }

    /**
     * Sets Type.
     *
     * @param string|null $value
     * @return $this
     * @see RetargetingListTypeEnum
     */
    public function setType($value = null)
    {
        $this->Type = $value;

        return $this;
    }

    /**
     * Gets Name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * Sets Name.
     *
     * @param string $value
     * @return $this
     */
    public function setName($value)
    {
        $this->Name = $value;

        return $this;
    }

    /**
     * Gets Description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return isset($this->Description) ? $this->Description : null;
    }

    /**
     * Sets Description.
     *
     * @param string|null $value
     * @return $this
     */
    public function setDescription($value = null)
    {
        $this->Description = $value;

        return $this;
    }

    /**
     * Gets Rules.
     *
     * @return RetargetingListRuleItem[]
     */
    public function getRules()
    {
        return $this->Rules;
    }

    /**
     * Sets Rules.
     *
     * @param RetargetingListRuleItem[] $value
     * @return $this
     */
    public function setRules(array $value)
    {
        $this->Rules = $value;

        return $this;
    }


}


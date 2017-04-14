<?php
namespace YuanBen;

use YuanBen\Contracts\Arrayable;
use YuanBen\Exceptions\InvalidDataTypeException;
use YuanBen\Exceptions\InvalidLicenseTypeException;

class License implements Arrayable
{
    const LICENSE_CC = 'cc';
    const LICENSE_CC_ADAPTATION_Y = 'y';
    const LICENSE_CC_ADAPTATION_N = 'n';
    const LICENSE_CC_ADAPTATION_SA = 'sa';
    const LICENSE_CC_COMMERCIAL_Y = 'y';
    const LICENSE_CC_COMMERCIAL_N = 'n';

    const LICENSE_CM = 'cm';
    const LICENSE_CM_ADAPTATION_Y = 'y';
    const LICENSE_CM_ADAPTATION_N = 'n';
    const LICENSE_CM_PRICE = 'price';

    protected $type;
    protected $price;
    protected $adaptation;
    protected $commercial;

    public function __construct($type)
    {
        $this->setType($type);
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $type = strtolower($type);
        if (! $this->typeCanBe($type)) {
            throw new InvalidLicenseTypeException("The type name {$type} is invalid on License.");
        }

        $this->type = $type;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->checkPrice($price);
        $this->price = $price;

        return $this;
    }

    public function getAdaptation()
    {
        return $this->adaptation;
    }

    public function setAdaptation($adaptation)
    {
        $adaptation = strtolower($adaptation);

        $this->checkAdaptation($adaptation);
        $this->adaptation = $adaptation;

        return $this;
    }

    public function getCommercial()
    {
        return $this->commercial;
    }

    public function setCommercial($commercial)
    {
        $commercial = strtolower($commercial);

        if ($this->type === self::LICENSE_CC) {
            $this->checkCommercial($commercial);
            $this->commercial = $commercial;
        }

        return $this;
    }

    protected function checkCommercial($commercial)
    {
        if (array_search($commercial, [self::LICENSE_CC_COMMERCIAL_Y, self::LICENSE_CC_COMMERCIAL_N]) === false) {
                throw new InvalidDataTypeException('The commercial value must be one of [y, n].');
        }
    }

    public function checkAdaptation($adaptation)
    {
        if ($this->type === self::LICENSE_CC) {
            $allows = [self::LICENSE_CC_ADAPTATION_N, self::LICENSE_CC_ADAPTATION_Y, self::LICENSE_CC_ADAPTATION_SA];

            if (array_search($adaptation, $allows) === false) {
                throw new InvalidDataTypeException('The adaptation value must be one of [y, n, sa].');
            }
        } else {
            $allows = [self::LICENSE_CM_ADAPTATION_Y, self::LICENSE_CM_ADAPTATION_N];

            if (array_search($adaptation, $allows) === false) {
                throw new InvalidDataTypeException('The adaptation value must be one of [y, n].');
            }
        }
    }

    public function checkPrice($price)
    {
        if (! is_numeric($price) || $price <= 0) {
            throw new InvalidDataTypeException('The data type of price must be a float and must greater then zero.');
        }
    }

    public function typeCanBe($type)
    {
        return array_search($type, [self::LICENSE_CC, self::LICENSE_CM]) !== false;
    }

    public function isValid()
    {
        return $this->checkValidOfCc() && $this->checkValidOfCm();
    }

    public function checkValidOfCc()
    {
        if ($this->type === self::LICENSE_CC) {
            $this->checkAdaptation($this->adaptation);
            $this->checkCommercial($this->commercial);
        }

        return true;
    }

    public function checkValidOfCm()
    {
        if ($this->type === self::LICENSE_CM) {
            $this->checkAdaptation($this->adaptation);
            $this->checkPrice($this->price);
        }

        return true;
    }

    public function isCC()
    {
        return $this->type === self::LICENSE_CC;
    }

    public function isCM()
    {
        return $this->type === self::LICENSE_CM;
    }

    public static function loadByJson($jsonData)
    {
        $data = \GuzzleHttp\json_decode($jsonData, true);

        if (! $data) {
            throw new InvalidDataTypeException('The argument must be a valid json string.');
        }

        if (! isset($data['type'])) {
            throw new InvalidDataTypeException("Key type is missing in array.");
        }

        if (! isset($data['content'])) {
            throw new InvalidDataTypeException("Key type.content is missing in array.");
        }

        $license = new self($data['type']);
        $content = $data['content'];

        if ($license->isCC()) {
            if (! isset($content['adaptation']) || ! isset($content['commercial'])) {
                throw new InvalidDataTypeException("Key type.content.adaptation or type.content.commercial is missing in array.");
            }

            $license->setAdaptation($content['adaptation'])
                ->setCommercial($content['commercial']);
        } else {
            if (! isset($content['adaptation']) || ! isset($content['price'])) {
                throw new InvalidDataTypeException("Key type.content.adaptation or type.content.price is missing in array.");
            }

            $license->setAdaptation($content['adaptation'])
                ->setPrice($content['price']);
        }

        return $license;
    }

    public function computeContent()
    {
        $content = [
            'adaptation' => $this->adaptation,
        ];
        if ($this->isCC()) {
            return array_merge($content, [ 'commercial' => $this->commercial ]);
        }

        return array_merge($content, ['price' => $this->price]);
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'content' => $this->computeContent()
        ];
    }
}

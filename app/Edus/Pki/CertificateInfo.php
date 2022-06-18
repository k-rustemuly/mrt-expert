<?php

namespace App\Edus\Pki;

class CertificateInfo
{
    protected $cert = [];
    public $notBefore = null;
    public $notAfter  = null;
    public $chain = [];

    public function __construct(array $certInfo)
    {
        $this->cert = $certInfo;
        $this->notBefore = new \DateTime($certInfo['notBefore']);
        $this->notAfter = new \DateTime($certInfo['notAfter']);

        if (isset($certInfo['chain']) && is_array($certInfo['chain']))
        {
            foreach ($certInfo['chain'] as $c)
            {
                $this->chain[] = new self($c);
            }
        }
    }

    public function getRaw():array
    {
        return $this->cert;
    }

    public function __get($name)
    {
        return $this->cert[$name];
    }

    public function __set($name, $value)
    {
        throw new \Exception('Certificate arguments setting not supported.');
    }

    public function __isset($name)
    {
        return isset($this->cert[$name]);
    }

    public function __unset($name)
    {
        throw new \Exception('CertificateInfo unset not supported');
    }

    /**
     * Проверяет, действителен ли сертификат на заданную дату?
     *
     * @param null $oDate Дата, если не указать, то берется текущее время
     * @return bool Результат проверки
     */
    public function isExpired($oDate = null):bool
    {
        if (!$oDate) {
            $oDate = new \DateTime('now');
        }

        return $this->notBefore > $oDate && $this->notAfter < $oDate;
    }

    /**
     * Проверяет, является ли сертификат законным для подписания?
     *
     * Здесь проверяется, срок (на стороне сервера), ocsp и crl (при указании) и цепочка, до КУЦ
     *
     * Для полноты проверки рекомендуется verifyOcsp или verifyCrl указывать в true
     *
     * @param bool $bCheckChain Проверять цепочку
     * @return bool
     */
    public function isLegal($bCheckChain = true):bool
    {

        // check date
        if (!$this->cert['valid']) return false;

        // check ocsp if present
        if (isset($this->cert['ocsp']) && $this->cert['ocsp']['status'] !== 'ACTIVE') return false;

        // check crl if present
        if (isset($this->cert['crl']) && $this->cert['crl']['status'] !== 'ACTIVE') return false;

        // check chain
        if ($bCheckChain)
        {
            if (!isset($this->cert['chain']) || !is_array($this->cert['chain']) || count($this->cert['chain']) == 0) {
                return false;
            } else {
                foreach ($this->chain as $chainCert) {
                    if (!$chainCert->isLegal(false)) return false;
                }
            }
        }

        return true;
    }

    /**
     * Проверяет, предназначен ли сертификат для аутентификации?
     *
     * @return bool
     */
    public function isAuth():bool
    {
        return $this->keyUsage == "AUTH";
    }

    /**
     * Проверяет, предназначен ли сертификат непосредственно для подписи документов?
     *
     * @return bool
     */
    public function isSign():bool
    {
        return $this->keyUsage == "SIGN";
    }

    /**
     * Проверяет, является ли пользователь ключа физическое лицо
     *
     * @return bool
     */
    public function isIndividual():bool
    {
        return in_array("INDIVIDUAL", $this->keyUser);
    }

    /**
     * Проверяет, является ли пользователь ключа Юридическое лицо
     *
     * @return bool
     */
    public function isLegalEntity():bool
    {
        return in_array("ORGANIZATION", $this->keyUser);
    }

    /**
     * Проверяет, является ли пользователь ключа первым руководителям юридического лица, имеющий право подписи
     *
     * @return bool
     */
    public function isCeo():bool
    {
        return in_array("CEO", $this->keyUser);
    }

    /**
     * Проверяет, является ли пользователь ключа лицо, наделенное правом подписи
     *
     * @return bool
     */
    public function isCanSign():bool
    {
        return in_array("CAN_SIGN", $this->keyUser);
    }

    /**
     * Проверяет, является ли пользователь ключа лицо, наделенное правом подписи финансовых документов
     *
     * @return bool
     */
    public function isCanSignFinancial():bool
    {
        return in_array("CAN_SIGN_FINANCIAL", $this->keyUser);
    }

    /**
     * Проверяет, является ли пользователь ключа сотрудником отдела кадров, наделенный правом подтверждать заявки на выпуск регистрационных свидетельств поданные от сотрудников юридического лица
     *
     * @return bool
     */
    public function isHr():bool
    {
        return in_array("HR", $this->keyUser);
    }

    /**
     * Проверяет, является ли пользователь ключа сотрудником организации
     *
     * @return bool
     */
    public function isEmployee():bool
    {
        return in_array("EMPLOYEE", $this->keyUser);
    }

    /**
     * Возвращает ФИО держателя ключа
     * 
     * @return string|null
     */
    public function getFullName()
    {
        $subject = $this->subject;
        $fullName = $subject["commonName"];
        return isset($subject["lastName"]) ? $fullName." ".$subject["lastName"] : $fullName;
    }

    /**
     * Держатель ключа мужчина?
     * 
     * @return bool
     */
    public function isMale():bool
    {
        return $this->subject["gender"] == "MALE";
    }

    /**
     * Держатель ключа женщина?
     * 
     * @return bool
     */
    public function isFemale():bool
    {
        return $this->subject["gender"] == "FEMALE";
    }

    /**
     * Дата рождения (берется из ИИН)
     * 
     * @return string|null
     */
    public function getBirthDate()
    {
        return $this->subject["birthDate"];
    }

    /**
     * ИИН
     * 
     * @return string
     */
    public function getIin():string
    {
        return $this->subject["iin"];
    }

    /**
     * БИН
     * 
     * @return string
     */
    public function getBin():string
    {
        return $this->isLegalEntity() ? $this->subject["bin"] : "000000000000";
    }

    /**
     * Название организации 
     * 
     * @return string
     */
    public function getOrganizationName():string
    {
        return $this->isLegalEntity() ? $this->subject["organization"] : "Undefined";
    }

    /**
     * Email
     * 
     * @return string|null
     */
    public function getEmail()
    {
        return $this->subject["email"];
    }
}
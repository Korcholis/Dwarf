<?php

namespace Dwarf\Model;

class Version extends \Dwarf\Base\DwarfClass {
  /**
   * Codename that will be included in queries
   * @var string
   */
  private $code;
  /**
   * Private codename to refer from your own codebase.
   * It can be a git commit, a date or a longer name. 
   * It's only purpose is to make it meaningful to the
   * developers and can be the same as {@see $code}
   * @var string
   */
  private $strongCode;
  /**
   * The day it was first released. This date should be the 
   * {@see $deprecationDate} of the previous Version
   * @var \DateTime
   */
  private $releaseDate;
  /**
   * After a new Version is released, it starts its
   * deprecation. This is used as a warning to any client
   * grabbing info from this Version. Normally, Versions
   * have a {@see $gracePeriod} that allows them to run
   * deprecated for a certain period.
   * @var \DateTime
   */
  private $deprecationDate;
  /**
   * Amount of time a Version is considered to be deprecated
   * but maintained. Its format is that of a \DateInterval. It
   * defaults to 1Y
   * @var \DateInterval
   */
  private $gracePeriod;
  /**
   * The date after which the grace period of a deprecation 
   * ends. After this moment, the Version is no longer 
   * accessible, and therefor any call to this Version will be
   * rejected. 
   * @var \DateTime
   */
  private $obsolescenceDate;
  /**
   * If this version is the latest (and more stable) version,
   * it will be set to true. False otherwise
   * @var boolean
   */
  private $latest;

  public function __construct($code, $strongCode, $releaseDate, $gracePeriod = "1Y", $deprecationDate = null, $obsolescenceDate = null, $latest = false) {
    $this->code = $code;
    $this->strongCode = $strongCode;
    if (is_string($releaseDate)) {
      $releaseDate = new \DateTime($releaseDate);  
      $this->releaseDate = $releaseDate;
    } elseif(get_class($releaseDate) == 'DateTime') {
      $this->releaseDate = clone $releaseDate;
    }
    if (is_string($gracePeriod)) {
      $gracePeriod = new \DateInterval("P$gracePeriod");
      $this->gracePeriod = $gracePeriod;
    } elseif(get_class($gracePeriod) == 'DateInterval') {
      $this->gracePeriod = clone $gracePeriod;
    }
    if (isset($deprecationDate)) {
      if (is_string($deprecationDate)) {
        $deprecationDate = new \DateTime($deprecationDate);  
        $this->deprecationDate = $deprecationDate;
      } elseif(get_class($deprecationDate) == 'DateTime') {
        $this->deprecationDate = clone $deprecationDate;
      }
    }
    if (isset($obsolescenceDate)) {
      if (is_string($obsolescenceDate)) {
        $obsolescenceDate = new \DateTime($obsolescenceDate);  
        $this->obsolescenceDate = $obsolescenceDate;
      } elseif(get_class($obsolescenceDate) == 'DateTime') {
        $this->obsolescenceDate = clone $obsolescenceDate;
      }
    }
    $this->latest = $latest;
  }

  /**
   * @return string
   */
  public function getCode() {
      return $this->code;
  }

  /**
   * @param string $code
   *
   * @return self
   */
  public function setCode($code) {
      $this->code = $code;

      return $this;
  }

  /**
   * @return string
   */
  public function getStrongCode() {
      return $this->strongCode;
  }

  /**
   * @param string $strongCode
   *
   * @return self
   */
  public function setStrongCode($strongCode) {
      $this->strongCode = $strongCode;

      return $this;
  }

  /**
   * @return \DateTime
   */
  public function getReleaseDate() {
      return $this->releaseDate;
  }

  /**
   * @param \DateTime $releaseDate
   *
   * @return self
   */
  public function setReleaseDate(\DateTime $releaseDate) {
      $this->releaseDate = $releaseDate;

      return $this;
  }

  /**
   * @return \DateTime
   */
  public function getDeprecationDate() {
      return $this->deprecationDate;
  }

  /**
   * @param \DateTime $deprecationDate
   *
   * @return self
   */
  public function setDeprecationDate(\DateTime $deprecationDate) {
      $this->deprecationDate = $deprecationDate;

      return $this;
  }

  /**
   * @return \DateInterval
   */
  public function getGracePeriod() {
      return $this->gracePeriod;
  }

  /**
   * @param \DateInterval $gracePeriod
   *
   * @return self
   */
  public function setGracePeriod(\DateInterval $gracePeriod) {
      $this->gracePeriod = $gracePeriod;

      return $this;
  }

  /**
   * @return \DateTime
   */
  public function getObsolescenceDate() {
      return $this->obsolescenceDate;
  }

  /**
   * @param \DateTime $obsolescenceDate
   *
   * @return self
   */
  public function setObsolescenceDate(\DateTime $obsolescenceDate) {
      $this->obsolescenceDate = $obsolescenceDate;

      return $this;
  }

  public function buildObsolescenceDate(\DateTime $deprecationDate, \DateInterval $gracePeriod) {
    $this->obsolescenceDate = clone $deprecationDate;
    $this->obsolescenceDate->add($gracePeriod);
  }

  /**
   * @return boolean
   */
  public function isLatest() {
      return $this->latest;
  }

  /**
   * @param boolean $latest
   *
   * @return self
   */
  public function setLatest($latest) {
      $this->latest = $latest;

      return $this;
  }
}
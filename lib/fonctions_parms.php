<?php


  /**
  *  prend en compte le paramètre $name
  *   qui doit représenter un entier sans signe
  *  @return : valeur retenue, convertie en int.
  *   - si le paramètre est absent ou vide, renvoie  $defaultValue
  *   - si le paramètre est incorrect, déclenche une exception ParmsException
  *
  */
 function checkUnsignedInt(string $name, ?int $defaultValue=NULL, bool $mandatory = TRUE) : ?int {
     if ( ! isset($_REQUEST[$name]) || $_REQUEST[$name]=="" ){
      if ($defaultValue !== NULL)
        return $defaultValue;
      else if ($mandatory)
        throw new ParmsException("$name absent");
      else
        return NULL;
     }
     $val = $_REQUEST[$name];
     if (! ctype_digit($val))
       throw new ParmsException("$name incorrect");
     return (int) $val;
  }

  /**
  *  prend en compte le paramètre $name
  *   qui doit représenter une chaîne
  *  @return : valeur retenue
  *   - si le paramètre est absent ou vide, renvoie  $defaultValue
  *   - si le paramètre est incorrect, déclenche une exception ParmsException
  *
  */
 function checkString(string $name, ?string $defaultValue=NULL, bool $mandatory = TRUE) : ?string {
     if ( ! isset($_REQUEST[$name]) || $_REQUEST[$name]=="" ){
      if ($defaultValue !== NULL)
        return $defaultValue;
      else if ($mandatory)
        throw new ParmsException("$name absent");
      else
        return NULL;
     }
     $val = $_REQUEST[$name];
     return $val;
  }

  /**
  *  prend en compte le paramètre $name
  *   qui doit représenter un nombre sans signe
  *  @return : valeur retenue
  *   - si le paramètre est absent ou vide, renvoie  $defaultValue
  *   - si le paramètre est incorrect, déclenche une exception ParmsException
  *
  */
 function checkNumber(string $name, ?int $defaultValue=NULL, bool $mandatory = TRUE) : ?int {
     if ( ! isset($_REQUEST[$name]) || $_REQUEST[$name]=="" ){
      if ($defaultValue !== NULL)
        return $defaultValue;
      else if ($mandatory)
        throw new ParmsException("$name absent");
      else
        return NULL;
     }
     $val = $_REQUEST[$name];
     if (! is_numeric($val))
       throw new ParmsException("$name incorrect");
     return (float) $val;
  }

 ?>

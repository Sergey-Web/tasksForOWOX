<?php

interface ILanguageSchool {
    function __construct(string $language);
    function setTypeLessons(string $type): ILanguageSchool;   
    function setPlan(string $plan): ILanguageSchool;   
    function setCountNumber(int $num): ILanguageSchool;   
}

interface ITypeCourse {
    function setTypeLessons(string $type): ITypeLessonsLanguageSchool;
}

interface IPlanCourse {
    function setPlan(string $plan): IPlanLanguageSchool;
}

interface ITypeLessonsLanguageSchool {
    function getType(): string;
}

interface IPlanLanguageSchool {
    function getCost(): int;
    function getUnit(): string;
}

abstract class AbstractCourse implements ITypeCourse, IPlanCourse {
    /**
     * @param string $type
     * @return ITypeLessonsLanguageSchool
     */
    public function setTypeLessons(string $type): ITypeLessonsLanguageSchool {
        if (!array_key_exists($type, $this->types)) {
            throw new \Exeption ('This course does not have this type of training.'); 
        }

        return new $this->types[$type];
    }

    /**
     * @param string $plan
     * @return IPlanLanguageSchool
     */
    public function setPlan(string $plan): IPlanLanguageSchool  {
        if (!array_key_exists($plan, $this->plans)) {
            throw new \Exeption ('This is no such tariff in this course.'); 
        }

        return new $this->plans[$plan];
    }
}

class Speaking implements ITypeLessonsLanguageSchool {
    private $type = 'speaking';

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}

class Grammar implements ITypeLessonsLanguageSchool {
    private $type = 'grammar';

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }   
}

class Fixed implements IPlanLanguageSchool {
    private $cost = 200;

    private $unit = 'lesson';

    /**
     * @return int
     */
    public function getCost(): int {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function getUnit(): string {
        return $this->unit;
    }
}

class Hourly implements IPlanLanguageSchool {
    private $cost = 100;

    private $unit = 'hour';

    public function getCost(): int {
        return $this->cost;
    }

    public function getUnit(): string {
        return $this->unit;
    }
}

class EnglishCourse extends AbstractCourse {
    public $types = [
        'speaking' => Speaking::class,
        'grammar' => Grammar::class
    ];

    public $plans = [
        'fixed' => Fixed::class,
        'hourly' => Hourly::class
    ];
}

class UkraineCourse extends AbstractCourse implements ITypeCourse, IPlanCourse {
    public $types = [
        'speaking' => Speaking::class
    ];

    public $plans = [
        'fixed' => Fixed::class
    ];
}

class LanguageSchool implements ILanguageSchool {
    public $course;
    public $type;
    public $cost;
    public $plan;
    public $unit;

    public $language = [
        'en' => EnglishCourse::class,
        'ua' => UkraineCourse::class
    ];

    public function __construct(string $language)
    {
        if (!array_key_exists($language, $this->language)) {
            throw new \Exeption('This is no such course');
        }
        $this->course = new $this->language[$language];
    }

    public function setTypeLessons(string $type): ILanguageSchool
    {
        $this->type = $this->course->setTypeLessons($type)->getType();

        return $this;
    }

    public function setPlan(string $plan): ILanguageSchool
    {
        $this->plan = $this->course->setPlan($plan)->getCost();
        $this->unit = $this->course->setPlan($plan)->getUnit();

        return $this;
    }

    public function setCountNumber(int $num): ILanguageSchool 
    {
        $this->cost = $this->plan * $num;

        return $this;
    }
}

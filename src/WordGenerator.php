<?php


class WordGenerator
{
    const VOWELS = ['a', 'e', 'i', 'o', 'u'] ;
    const CONSONANTS = ['b', 'c', 'd', 'f', 'g', 'j', 'k', 'l', 'm', 'n', 'p',
        'q', 's', 't', 'v', 'x','z', 'h', 'r', 'w', 'y'];
    /* number of last index of VOWELS array*/
    const VOWELS_COUNT = 4;
    /* number of last index of CONSONANTS array*/
    const CONSONANTS_COUNT = 20;
    /* boundaries between which number of letters in word will be chosen randomly */
    private $min_letters;
    private $max_letters;
    /* tracks number of consonants in a row, in a word */
    private $consonants_in_row;
    /* tracks created words */
    private $words_created;

    public function __construct(int $min_letters, int $max_letters)
    {
        $this->max_letters = (int)$max_letters;
        $this->min_letters = (int)$min_letters;
        $this->words_created = [];
        $this->consonants_in_row = 0;
    }

    public function createWord(): string
    {
        //max 2 consonants in a row
        //first always consonant, second vowel
        //always unique
        /*
         * get random consonant
         * get random vowel
         * in loop:
         * check consonants_in_row flag/value
         * if flag == 2 get random vowel
         * else get random consonant or vowel
         * if consonant increment flag
         */

        do {
            /* get random word length between given boundaries */
            $wordLength = mt_rand($this->min_letters, $this->max_letters);
            /* first is always consonant */
            $newWord = $this->getRandomConsonant();
            /* second always vowel */
            $newWord .= $this->getRandomVowel();
            /* initiate needed variables  */
            $this->consonants_in_row = 0;
            $currentLength = 2;
            //________________________________________________________________________________________________
            while ($currentLength < $wordLength) {
                /* check if word have two consonants in a row */
                if ($this->consonants_in_row < 2) {
                    /* if not, get vowel or consonant randomly */
                    switch (mt_rand(0, 1)) {
                        case 0:
                        {
                            $newWord .= $this->getRandomVowel();
                            /* last letter inserted is vowel so consonant in a row equals 0 */
                            $this->consonants_in_row = 0;
                            break;
                        }
                        case 1:
                        {
                            $newWord .= $this->getRandomConsonant();
                            /* increment consonants in a row */
                            $this->consonants_in_row += 1;
                            break;
                        }
                    }
                } else {
                    $newWord .= $this->getRandomVowel();
                    /* last letter inserted is vowel so consonant in a row equals 0 */
                    $this->consonants_in_row = 0;
                }
                $currentLength++;
            }
            //________________________________________________________________________________________________
        } while (in_array($newWord, $this->words_created)); /* if words is in an array, means such a word was already generated */
        /* add created word to array that contains previously created words */
        $this->words_created[] = $newWord;
        return $newWord;
    }

    /**
     * @return string random letter from VOWEL const
     */
    private function getRandomVowel(): string{
        $randomIndex = mt_rand(0, self::VOWELS_COUNT);
        return self::VOWELS[$randomIndex];
    }

    /**
     * @return string random letter from Consonant const
     */
    private function getRandomConsonant(): string{
        $randomIndex = mt_rand(0, self::CONSONANTS_COUNT);
        return self::CONSONANTS[$randomIndex];
    }

    /**
     * @return int
     */
    public function getMinLetters(): int
    {
        return $this->min_letters;
    }

    /**
     * @param int $min_letters
     */
    public function setMinLetters(int $min_letters): void
    {
        $this->min_letters = $min_letters;
    }

    /**
     * @return int
     */
    public function getMaxLetters(): int
    {
        return $this->max_letters;
    }

    /**
     * @param int $max_letters
     */
    public function setMaxLetters(int $max_letters): void
    {
        $this->max_letters = $max_letters;
    }

    /**
     * @return array
     */
    public function getWordsCreated(): array
    {
        return $this->words_created;
    }

    /**
     * @param array $words_created
     */
    public function setWordsCreated(array $words_created): void
    {
        $this->words_created = $words_created;
    }


}
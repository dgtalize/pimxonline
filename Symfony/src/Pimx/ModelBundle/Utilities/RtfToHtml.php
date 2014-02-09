<?php

namespace Pimx\ModelBundle\Utilities;

/* * ************************************************************************\
 * * This program is my attempt at creating an RTF to HTML converter. In**
 * * its present form it creates an array called newFile that I simply **
 * * print to the browser. If you go to this page for the first time, it**
 * * displays a form to upload a file. If you upload a file, it tries to**
 * * convert it into html and display it. It works fairly well for RTF **
 * * files created with Wordpad as long as you don't try to insert a**
 * * picture.**
 * ************************************************************************** */

class RtfToHtml {
    private $color;
    private $size;
    private $bullets;
    private $alignsOpened;
    
    private function processTags($tags, $lineNumber) {
        $html = "";
// Remove spaces.
        $tags = trim($tags);
// Found the beginning of the bulleted list.
        if (ereg("\\\pnindent", $tags)) {
            $html .= "<ul><li>";
            $this->bullets += $lineNumber;
            $tags = ereg_replace("\\\par", "", $tags);
            $tags = ereg_replace("\\\(tab)", "", $tags);
        //}
            if ($lineNumber - $this->bullets == 0) {
                $tags = ereg_replace("\\\par", "", $tags);
            } elseif ($lineNumber - $this->bullets == 1) {
                if (ereg("\\\pntext", $tags)) {
                    $html .= "<li>";
                    $tags = ereg_replace("\\\par", "", $tags);
                    $tags = ereg_replace("\\\(tab)", "", $tags);
                    $this->bullets++;
                } else {
                    $html .= "</ul>";
                    $this->bullets = 0;
                }
            }
        }
// Convert Alignments.
        if (ereg("\\\pard\\\qc", $tags)) {
            $html .= "<div align=center>";
            $this->alignsOpened++;
        } elseif (ereg("\\\pard\\\qr", $tags)) {
            $html .= "<div align=right>";
            $this->alignsOpened++;
        } elseif (ereg("\\\pard", $tags)) {
            $html .= "<div align=left>";
            $this->alignsOpened++;
        }
// Convert Bold.
        if (ereg("\\\b0", $tags)) {
            $html .= "</span>";
        } elseif (ereg("\\\b", $tags)) {
            $html .= '<span style="font-weight: bold;">';
        }
// Convert Italic.
        if (ereg("\\\i0", $tags)) {
            $html .= "</i>";
        } elseif (ereg("\\\i", $tags)) {
            $html .= "<i>";
        }
// Convert Underline.
        if (ereg("\\\ulnone", $tags)) {
            $html .= "</u>";
        } elseif (ereg("\\\ul", $tags)) {
            $html .= "<u>";
        }
// Remove \pard from the tags so it doesn't get confused with \par.
        $tags = ereg_replace("\\\pard", "", $tags);
        
// Close alignments
        if (ereg("\\\par", $tags)) {
            if($this->alignsOpened > 0){
                $html .= str_repeat("</div>", $this->alignsOpened);
                $this->alignsOpened = 0;
            }
        }
// Convert line breaks.
        if (ereg("\\\par", $tags)) {
            $html .= "<br/>";
        }
// Use the color table to capture the font color changes.
        if (ereg("\\\cf[0-9]", $tags)) {
            global $fcolor;
            $numcolors = count($fcolor);
            for ($i = 0; $i < $numcolors; $i++) {
                $test = "\\\cf" . ($i + 1);
                if (ereg($test, $tags)) {
                    $this->color = $fcolor[$i];
                }
            }
        }
// Capture font size changes.
        if (ereg("\\\fs[0-9][0-9]", $tags, $temp)) {
            $this->size = ereg_replace("\\\fs", "", $temp[0]);
            $this->size /= 2;
            if ($this->size <= 10) {
                $this->size = 1;
            } elseif ($this->size <= 12) {
                $this->size = 2;
            } elseif ($this->size <= 14) {
                $this->size = 3;
            } elseif ($this->size <= 16) {
                $this->size = 4;
            } elseif ($this->size <= 18) {
                $this->size = 5;
            } elseif ($this->size <= 20) {
                $this->size = 6;
            } elseif ($this->size <= 22) {
                $this->size = 7;
            } else {
                $this->size = 8;
            }
        }
// If there was a font color or size change, change the font tag now.
        if (ereg("(\\\cf[0-9])|(\\\fs[0-9][0-9])", $tags)) {
            $html .= "</font><font size=$this->size color=$this->color>";
        }
// Replace \tab with alternating spaces and nonbreakingwhitespaces.
        if (ereg("\\\(tab)", $tags)) {
            $html .= "        ";
        }
        return $html;
    }

    private function processWord($word) {
// Replace \\ with \
        $word = ereg_replace("[\\]{2,}", "\\", $word);
// Replace \{ with {
        $word = ereg_replace("[\\][\{]", "\{", $word);
// Replace \} with }
        $word = ereg_replace("[\\][\}]", "\}", $word);
// Replace 2 spaces with one space.
        $word = ereg_replace(" ", "  ", $word);
        return $word;
    }

    public function convert($rtfText) {
        $this->color = "000000";
        $this->size = 1;
        $this->bullets = 0;
        $this->alignsOpened = 0;
        
        $htmlText = "";
// Read the uploaded file into an array.
        //$rtfile = file($userfile);
        $rtfLines = explode("\r\n", $rtfText);
        //$fileLength = count($rtfile);
        $lineCount = count($rtfLines);
// Loop through the rest of the array
        for ($i = 0; $i < $lineCount; $i++) {
            $rtfLine = $rtfLines[$i] . "\n";
            /*
             * * If the line contains "\colortbl" then we found the color table.
             * * We'll have to split it up into each individual red, green, and blue
             * * Convert it to hex and then put the red, green, and blue back together.
             * * Then store each into an array called fcolor.
             */
            if (ereg("^\{\\\colortbl", $rtfLine)) {
                // Split the line by the backslash.
                $colors = explode("\\", $rtfLine);
                $numOfColors = count($colors);
                for ($k = 2; $k < $numOfColors; $k++) {
                    // Find out how many different colors there are.
                    if (ereg("[0-9]+", $colors[$k], $matches)) {
                        $match[] = $matches[0];
                    }
                }

                // For each color, convert it to hex.
                $numOfColors = count($match);
                for ($k = 0; $k < $numOfColors; $k += 3) {
                    $red = dechex($match[$k]);
                    $red = $match[$k] < 16 ? "0$red" : $red;
                    $green = dechex($match[$k + 1]);
                    $green = $match[$k + 1] < 16 ? "0$green" : $green;
                    $blue = dechex($match[$k + 2]);
                    $blue = $match[$k + 2] < 16 ? "0$blue" : $blue;
                    $fcolor[] = "$red$green$blue";
                }
                $numOfColors = count($fcolor);
            }
// Or else, we parse the line, pulling off words and tags.
            else {
                $token = "";
                $start = 0;
                $lineLength = strlen($rtfLine);
                for ($k = 0; $k < $lineLength; $k++) {
                    if ($rtfLine[$start] == "\\" && $rtfLine[$start + 1] != "\\") {
// We are now dealing with a tag.
                        $token .= $rtfLine[$k];
                        if ($rtfLine[$k] == " ") {
                            //$newFile[$i] .= ProcessTags($token, $i);
                            $htmlText .= $this->processTags($token, $i);
                            $token = "";
                            $start = $k + 1;
                        } elseif ($rtfLine[$k] == "\n" || $rtfLine[$k] == "\r") {
                            //$newFile[$i] .= ProcessTags($token, $i);
                            $htmlText .= $this->processTags($token, $i);
                            $token = "";
                        }
                    } elseif ($rtfLine[$start] == "{") {
// We are now dealing with a tag.
                        $token .= $rtfLine[$k];
                        if ($rtfLine[$k] == "}") {
                            //$newFile[$i] .= ProcessTags($token, $i);
                            $htmlText .= $this->processTags($token, $i);
                            $token = "";
                            $start = $k + 1;
                        }
                    } else {
// We are now dealing with a word.
                        if ($rtfLine[$k] == "\\" && $rtfLine[$k + 1] != "\\" && $rtfLine[$k - 1] != "\\") {
                            //$newFile[$i] .= ProcessWord($token);
                            $htmlText .= $this->processWord($token);
                            $token = $rtfLine[$k];
                            $start = $k;
                        } else {
                            $token .= $rtfLine[$k];
                        }
                    }
                }
            }
        }
//        $limit = sizeof($newFile);
//        for ($i = 0; $i < $limit; $i++) {
//            print("$newFile[$i]\n");
//        }
        return $htmlText;
    }

}
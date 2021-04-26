<?php

class Bildauswahl
{
    // Id für das Bildauswahl innerhalb eines Modules, wird für die Interaktion mit dem Medienpool benötigt.
    private static $id = 0;

    private $rid;
    private $slice;
    private $path2Value;
    private $label;
    private $mediaId;

    function __construct($label, $rid, $path2Value, $slice)
    {
        $this->rexValueId = $rid;
        $this->path2Value = $path2Value;
        if($slice == null) {
            throw new RuntimeException("Die Bildauswahl kann nicht ohne Slice exisitieren!");
        }
        $this->rexValue = rex_var::toArray($slice->getValue($this->rexValueId));
        $this->label = $label;
        $this->mediaId = self::$id;
        self::$id += 1;
    }

    public function getHTML()
    {
        $output = '';

        $rex_value_1 = '';
        if (isset($this->rexValue) && $this->rexValue != null) {
            $curNode = null;
            foreach ($this->path2Value as $NodeName) {
                if($curNode == null) {
                    // Besuch des ersten Knoten von der Wurzel aus
                    if(isset($this->rexValue[$NodeName]) && $this->rexValue[$NodeName] != null) {
                        // Durchlaufe die Knoten des Baumes bis zum Blatt.
                        $curNode = $this->rexValue[$NodeName];
                    }
                } else {
                    // Besuche Kind vom aktuellen Knoten ($curNode)
                    if(isset($curNode[$NodeName]) && $curNode[$NodeName] != null) {
                        // Wert vorhanden.
                        $curNode = $curNode[$NodeName];
                    } else {
                        // Modul initial hinzugefügt oder kein Wert im Bildauswahl gesetzt.
                        // $output .= '<script>console.log(">?");</script>';
                        $curNode = null;
                        break;
                    }
                }
            }
            if($curNode != null) {
                $rex_value_1 = $curNode;
            }
        }
        // JavaScript und CSS einmalig der Page hinzufügen
        if ($this->mediaId == 0) {
            $output .= '<script>
                function setPicture(id) {
                    var picture = document.getElementById(\'REX_MEDIA_\'+id).value;
                    if(picture !== "") {
                        console.log("Bild ausgewählt: " + picture);
                        document.getElementById(\'REX_MEDIA_\'+id+\'_PREVIEW\').src = \'/media/\'  + picture
                    } else {
                        console.log("Kein Bild ausgewählt");
                        document.getElementById(\'REX_MEDIA_\'+id+\'_PREVIEW\').src = "";
                    }
                }
            </script>';
            $output .= '<style>
                    .rex-slice .input-wrapper:hover img {
                        z-index: 4;
                        object-fit: initial;
                        max-width: 300px;
                    }
                    .input-wrapper:hover {
                        overflow: initial;
                    }
                    .input-wrapper {
                        width: 36px;
                        height: 36px;
                        background-color: #e9ecf2;
                        border: 1px solid #9fcce1;
                        float: left;
                        overflow: hidden;
                    }
                    .bildauswahl .input-group .form-control {
                        width: calc(100% - 36px);
                    }
                    .rex-slice .input-wrapper img {
                        object-fit: contain;
                        position: relative;
                        z-index: 3;
                        display: block;
                    }
                </style>';
        }
        $output .= '
            <label style="width: 100%;">' . $this->label . ':</label>
            <div class="rex-js-widget rex-js-widget-media bildauswahl">
                <div class="input-group">
                    <div class="input-wrapper">
                        <img id="REX_MEDIA_' . $this->mediaId . '_PREVIEW" src="" />
                    </div>
                    <input class="form-control" 
                        onchange="setPicture(' . $this->mediaId . ');"
                        type="text" name="REX_INPUT_VALUE[' . $this->rexValueId . '][' . join("][", $this->path2Value) . ']" 
                        value="' . $rex_value_1 . '" 
                        id="REX_MEDIA_' . $this->mediaId . '" 
                        readonly>
                    <script>   
                        setPicture(' . $this->mediaId . ');
                    </script>
                    <span class="input-group-btn">
                        <a href="#" class="btn btn-popup" 
                            onclick="openREXMedia(' . $this->mediaId . ',\'\');return false;" 
                            title="Medium auswählen">
                                <i class="rex-icon rex-icon-open-mediapool"></i>
                        </a>
                        <a href="#" class="btn btn-popup" 
                            onclick="addREXMedia(' . $this->mediaId . ',\'\');return false;" 
                            title="Neues Medium hinzufügen">
                                <i class="rex-icon rex-icon-add-media"></i>
                        </a>
                        <a href="#" class="btn btn-popup" 
                            onclick="deleteREXMedia(' . $this->mediaId . ');return false;" 
                            title="Ausgewähltes Medium löschen">
                                <i class="rex-icon rex-icon-delete-media"></i>
                        </a>
                        <a href="#" class="btn btn-popup" 
                            onclick="viewREXMedia(' . $this->mediaId . ',\'\');return false;" 
                            title="Ausgewähltes Medium anzeigen">
                                <i class="rex-icon rex-icon-view-media"></i>
                        </a>
                    </span>
                </div>
                <div class="rex-js-media-preview"></div>
            </div>';
        return $output;
    }
}

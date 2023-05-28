<?php

        $title = "Привет! Я помогу найти занятия рядом с вами. ";
        $description = "Скажите, например: «Пение», «Скандинавская ходьба» или «Гимнастика район Хамовники»";
        $tts = $title ." ". $description;

        $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
    
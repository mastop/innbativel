<?php

namespace Podesta\Mail;

class Mailer extends \Illuminate\Mail\Mailer {

    /**
     * Render the given view.
     *
     * @param  string  $view
     * @param  array   $data
     * @return \Illuminate\View\View
     */
    protected function getView($view, $data)
    {
        $cssInline = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();

        $view = $this->views->make($view, $data)->render();

        $cssInline->setUseInlineStylesBlock();
            $cssInline->setStripOriginalStyleTags();
            $cssInline->setCleanup();
            $cssInline->setHTML($view);

        return $cssInline->convert();
    }

}

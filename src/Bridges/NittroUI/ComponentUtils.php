<?php

namespace Nittro\Bridges\NittroUI;

use Nette\Application\UI\Presenter;


trait ComponentUtils {

    /**
     * @param bool $throw
     * @return Presenter
     */
    abstract public function getPresenter($throw = TRUE);

    /**
     * @param string $name
     * @return string
     */
    abstract public function getSnippetId($name);


    /************* Redirects *************/

    /**
     * @param string $destination
     * @param array $args
     * @return $this
     */
    public function postGet($destination, $args = [])
    {
        $presenter = $this->getPresenter();

        if ($presenter->isAjax()) {
            $presenter->payload->postGet = true;
            $presenter->payload->url = call_user_func_array([$presenter, 'link'], func_get_args());
        } else {
            call_user_func_array([$presenter, 'redirect'], func_get_args());
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function allowAjax()
    {
        $this->getPresenter()->payload->allowAjax = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disallowAjax()
    {
        $this->getPresenter()->payload->allowAjax = false;
        return $this;
    }


    /************* Forms *************/

    /**
     * @return $this
     */
    public function allowFormReset()
    {
        $this->getPresenter()->payload->allowReset = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disallowFormReset()
    {
        $this->getPresenter()->payload->allowReset = false;
        return $this;
    }


    /************* Dialogs *************/

    /**
     * @param string $snippet
     * @param string $name
     * @return $this
     */
    public function openInDialog($snippet, $name)
    {
        $this->getPresenter()->payload->dialogs[$name] = $this->getSnippetId($snippet);
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function closeDialog($name)
    {
        $this->getPresenter()->payload->dialogs[$name] = false;
        return $this;
    }

}

@foreach ($categoryRepo::treeAll() as $i => $cat)
    @php xdebug_break(); @endphp
    @if (count($cat['children_recursive']))
        $self         = $this;
        $this->string .= $this->view->render('components.catalog_mobile_menu.li-expand', compact('cat', 'self'));
        $this->recurse($cat['children_recursive']);
    @else
        $this->string .= $this->view->render('li', compact('cat'))
        @endif
        @endforeach
        </ul></li>

@include('admin.layouts.widget.button.button_link.button', ['icon' => $icon ?? 'fa-edit', 'url' => $url, 'btn_type' => $btn_type ?? 'default', 'text' => $text ?? __('admin.label.edit'), 'options' => $options ?? []])
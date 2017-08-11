<tr>
    <td>
        {{Form::text('delivery_name[]', null, array('class' => 'form-control'))}}
    </td>
    <td>
        {{Form::number('delivery_price[]', null, array('class' => 'form-control'))}}
    </td>
    <td>
        <button onclick="remove()"
                class="btn btn-danger" type="button">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        </button>
    </td>
</tr>
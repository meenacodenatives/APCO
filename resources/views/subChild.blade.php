@foreach($childs as $child)

<tr style="color:#000 !important">
    <td>-- {{$child->name }}</td>
    <td>{{$child->code}}</td>
    @if(strlen($child->description)>25)
    <td data-container="body" data-toggle="popover" data-popover-color="default" data-placement="bottom"
        title="{{$child->code}}" data-content="{{$child->description}}">
        {{\Illuminate\Support\Str::limit($child->description,25)}}
    </td>
    @else
    <td>
        {{$child->description}}
    </td>
    @endif
    <td>{{date('M d, Y', strtotime($child->created_at))}}</td>
    <td> <a id="confirmCatEdit" data-id="<?= base64_encode($child->id); ?>"
            class="ubtn<?= base64_encode($child->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0" data-toggle="tooltip"
            data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
        <a id="confirmCatDelete" data-id="<?= $child->id; ?>"
            class="ubtn<?= $child->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0" data-toggle="tooltip"
            data-original-title="Delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;
        <span class="delcat<?= $child->id; ?>"></span>
    </td>
</tr>
@endforeach
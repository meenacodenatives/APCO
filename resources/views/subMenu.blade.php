@foreach($childs as $child)
<tr style="color:#000 !important">
    <td>-- {{$child->menu_name }}</td>
    @if($child->menu_link!='')
    <td><a href="/apco/{{$child->menu_link}}">{{$child->menu_name}}</a></td>
    @else
    <td>{{$child->menu_name}}</td>
    @endif
    <td>{{$child->menu_controller}}</td>
    <td>{{date('M d, Y', strtotime($child->created_at))}}</td>
    <td> <a id="confirmMenuEdit" data-id="<?= base64_encode($child->id); ?>"
            class="ubtn<?= base64_encode($child->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0" data-toggle="tooltip"
            data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
            <a id="confirmMenuAssignUser" data-id="<?= base64_encode($child->id); ?>"
                                        class="ubtn<?= base64_encode($child->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Assign User"><i
                                            class="fa fa-plus"></i></a>&nbsp;&nbsp;
        <a id="confirmMenuDelete" data-id="<?= $child->id; ?>"
            class="ubtn<?= $child->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0" data-toggle="tooltip"
            data-original-title="Delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;
        <span class="delmenu<?= $child->id; ?>"></span>
    </td>
</tr>
@endforeach
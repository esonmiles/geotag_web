<?php
session_start();

if (isset($_POST) && !empty($_POST)) {
    include "../classes/post.php";
    $post = new Post();

    $field_name = $_POST['field_name'];
    $fieldType = $_POST['fieldType'];
    $subFieldType = $_POST['subFieldType'];
    $projectId = $_POST['projectId'];
    $isRequired = $_POST['isRequired'];

    $i = 0;
    $field = array();

    foreach ($_POST as $key => $value) {

        if ($key == 'field_name') {
            $field_name = $value;
        } else if ($key == 'fieldType') {
            $fieldType = $value;
        } else if ($key == 'subFieldType') {
            $subFieldType = $value;
        } else if ($key == 'isRequired') {
            $isRequired = $value;
        } else {
            $field[$i] = $value;

            $i++;
        }
    }

    if ($fieldType == 1) {
        if ($isRequired == '')
            $isRequired = 0;
        $post->postInsertFieldAlpha($field_name, $fieldType, $subFieldType, $projectId, $isRequired);
    } else {

        $fieldId = $post->postInsertFieldChoices($field_name, $fieldType, $projectId);
        $x = 1;
        foreach ($field as $name => $choiceValue) {
            if ($x != $i) {
                if (($isRequired == 1 and $x != 1) or $isRequired == 0) {
                    if ($choiceValue != '') {
                        $choiceId = $post->postCheckChoices($choiceValue);

                        $post->postInsertSubFieldChoices($fieldId, $fieldType, $choiceId);
                    }
                }
            }
            $x++;
        }
    }
}
?>
<script>
    parent.alert("Field record has been saved!");
    parent.$("#submitFieldForm").removeClass("disabled");
    parent.$(".pagePanel").load("<?php echo $path ?>php/addFieldRecord.php", {projectId: <?php echo $projectId ?>}, function () {
        
    });
</script>
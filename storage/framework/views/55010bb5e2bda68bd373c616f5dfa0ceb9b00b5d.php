<div>
    <div style="margin-left: 30px; display:inline-flex">
        <div class="form-group" style="margin-left: 30px;">
            <label for="exampleInputFile">Change Profile Image</label>
            <input type="file" id="image" wire:change="$emit('fileChosen')" onchange="validateFileType()" >
        </div>
    </div>
    <script>
        window.livewire.on('fileChosen', () => {
            let inputField = document.getElementById('image')
            let file = inputField.files[0]
            let reader = new FileReader();
            reader.onloadend = () => {
                //console.log(reader.result);
                window.livewire.emit('fileUpload', reader.result)
            }
            reader.readAsDataURL(file);
        })
    </script>
    <script type="text/javascript">
        function validateFileType(){
            var fileName = document.getElementById("image").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                //TO DO
            }else{
                alert("Only jpg, jpeg, and png files are allowed!");
                document.getElementById("image").value=null;
            }
        }
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\coopmanager\resources\views/livewire/upload-profile-image.blade.php ENDPATH**/ ?>
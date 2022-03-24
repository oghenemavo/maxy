  {!! Form::open(['route' => 'checkoutFile', 'files' => true]) !!}

        <div class="dropzone" id="myDropzone">
                              <div class="dz-default dz-message">Upload file here...</div>
        </div>

        <div class="form-group">
            <label for="recipient-name" class="form-control-label">Version:</label>
            <input type="text" name="version" class="form-control">
        </div>
     
        <div class="form-group">
            <label for="message-text" class="form-control-label">Comments:</label>
            <textarea class="form-control" name="description" id="description"></textarea>
        </div>

        <button type="submit" id="submit-all" class="btn btn-primary">Upload</button>

    </form>
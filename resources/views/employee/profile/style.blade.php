@section('style')
<style>
.img-circle{
  width: 100%;
  border: 4px solid #87ceeb;
  aspect-ratio: 1 / 1;
  margin: 0 auto;
  overflow: hidden;
  position: relative;
}

.img-circle img{
  width: 110%;
  height: auto;
  transform: translate(-50%,-50%);
  position: absolute;
  left: 50%;
  top: 50%;
  object-fit: cover;
  max-width: 110%;
}

a.media-img .img-circle{
  width: 40px;
  border: 1px solid #87ceeb;
  background-size: cover;
  background-position: center;
}

div.media-img .img-circle{
  width: 60px;
  border: 1px solid #87ceeb;
  background-size: cover;
  background-position: center;
}

.img-circle.circle-danger{
  border: 4px solid #e74c3c;
}

.profile-social a {
  font-size: 16px;
  margin: 0 10px;
  color: #999;
}

.profile-social a:hover {
  color: #485b6f;
}

.profile-stat-count {
  font-size: 22px
}

.img-profile{
  position: relative;
  cursor: pointer;
}

.img-upload{
  display: none;
  position: absolute;
  background: rgba(0,0,0,.5);
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  border-radius: 50%;
  transition: all .3s linear;
  opacity: .7;
}

.img-upload img{
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}

.img-profile:hover .img-upload{
  display: block;
}

li.media.text-right .media-img{
    padding-left: 14px;
    padding-right: 0;
}

.uploader-area {
  padding: 20px;
  background: #fff;
  border: 1px solid rgba(0,0,0,.15);
  border-radius: 5px;
  color: #999;
  cursor: pointer;
}
.uploader-loader {
  position: absolute;
  overflow: hidden;
  width: 1px;
  height: 1px;
  padding: 0;
  border: 0;
  clip: rect(0 0 0 0);
}
.uploaded-file-wrapper {
  float: left;
  padding-top: 15px;
  padding-bottom: 15px;
  border-bottom: #e9ecef 1px solid;
}
.uploaded-file-thumb {
  float: left;
  padding-right: 15px;
}
.uploaded-file-thumb img {
  width: 80px;
  height: 80px;
  border-radius: 15px;
}
.uploaded-file-title {
  color: #e46a76;
}
.has-error .uploader-area{
  border-color: #e74c3c;
}
#image_url {
    display: none; /* Hide the file input */
}

.uploader-area {
    cursor: pointer;
    border: 1px solid #ccc;
    padding: 10px;
    display: block;
}
.has-error input,
.has-error textarea {
    border-color: red !important;
}

.error-message {
    color: red;
    font-size: 12px;
}
</style>
@endsection

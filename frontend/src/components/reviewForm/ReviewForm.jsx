import { useState } from "react";
import axios from "axios";
import LoadingButton from "@mui/lab/LoadingButton";
import ProfileAvatar from "../ProfileAvatar";

const ReviewForm = ({
  progress,
  setProgress,
  showReview,
  singleCourse,
  userData,
}) => {
  // useState
  const [reviewText, setReviewText] = useState("");

  function handleReviewText(event) {
    setReviewText(event.target.value);
  }

  function handleSubmitReview(event) {
    setProgress(true);
    event.preventDefault();
    axios
      .post("http://localhost:8000/api/testimonial/store", {
        userId: userData.id,
        courseId: singleCourse.courseId,
        text: reviewText,
      })
      .then(() => {
        setReviewText("");
        showReview();
        setProgress(false);
      })
      .catch((error) => console.error(error));
  }

  return (
    <form onSubmit={handleSubmitReview}>
      <div className="row my-5">
        <div className="col-lg-2 col-md-3 col-sm-12 mb-3 d-flex justify-content-center">
          <ProfileAvatar
            photo={userData.profile_photo_path}
            name={userData.name}
            width={70}
            height={70}
          />
        </div>
        <div className="col-lg-10 col-md-9 col-sm-12 text-lg-end">
          <div className="row">
            <div className="col-12">
              <textarea
                value={reviewText}
                className="form-control w-100"
                rows="7"
                placeholder="Write a review here..."
                onChange={handleReviewText}
              ></textarea>
            </div>
            <div className="col-lg-3 offset-lg-9 col-md-4 offset-md-8 col-sm-12 d-flex justify-content-lg-end justify-content-center my-3">
              <LoadingButton
                type="submit"
                loading={progress}
                variant="contained"
                className="w-100"
              >
                Submit
              </LoadingButton>
            </div>
          </div>
        </div>
      </div>
    </form>
  );
};
export default ReviewForm;

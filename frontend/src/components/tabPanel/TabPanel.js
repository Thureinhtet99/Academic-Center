import {
  Box,
  Button,
  FormControl,
  IconButton,
  InputLabel,
  MenuItem,
  Select,
  Tab,
  Tabs,
} from "@mui/material";
import { useContext, useEffect, useState } from "react";
import ReviewForm from "../reviewForm/ReviewForm";
import { Link } from "react-router-dom";
import "./tabPanel.css";
import ReactTimeAgo from "react-time-ago";
import ProfileAvatar from "../ProfileAvatar";
import LoadingButton from "@mui/lab/LoadingButton";
import ThumbUpOffAltIcon from "@mui/icons-material/ThumbUpOffAlt";
import ThumbUpIcon from "@mui/icons-material/ThumbUp";
import DeleteIcon from "@mui/icons-material/Delete";
import PaginationComponent from "../PaginationComponent";
import dateTimeFormat from "../../context/DateTimeFormat";
import { UserDataContext } from "../../context/UserContext";
import { baseApi } from "../../api/BaseApi";

const CustomTabPanel = ({ children, value, index, ...other }) => {
  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`simple-tabpanel-${index}`}
      aria-labelledby={`simple-tab-${index}`}
      {...other}
    >
      {value === index && <Box sx={{ p: 3 }}>{children} </Box>}
    </div>
  );
};

const a11yProps = (index) => {
  return {
    id: `simple-tab-${index}`,
    "aria-controls": `simple-tabpanel-${index}`,
  };
};

const Tabpanel = ({
  userData,
  userToken,
  singleCourse,
  setReviewList,
  reviewList,
  showReview,
  progress,
  setProgress,
  courseId,
  handleReviewDelete,
}) => {
  // useState
  const [value, setValue] = useState(0);

  const [lessons, setLessons] = useState([]);

  const [sortReview, setSortReview] = useState("");
  const [likedReviewIdList, setLikedReviewIdList] = useState([]);
  const [likedReviewUserIdList, setLikedReviewUserIdList] = useState([]);

  const [currentPage, setCurrentPage] = useState(1);
  const [currentItem, setCurrentItem] = useState([]);

  const itemsPerPage = 5;

  // Fetch course
  async function fetchCourse() {
    try {
      const response = await baseApi.post("/course/show", {
        courseId: courseId,
      });
      setLessons(response.data.lessons);
    } catch (error) {
      console.error(error);
    }
  }
  // Fetch liked review list
  async function fetchLikedReview() {
    try {
      const response = await baseApi.get("/testimonial-like-counts");
      setLikedReviewIdList(
        response.data.map((reviewId) => reviewId.testimonial_id)
      );
      setLikedReviewUserIdList(response.data.map((userId) => userId.user_id));
    } catch (error) {
      console.error(error);
    }
  }

  // useEffect
  useEffect(() => {
    setProgress(true);
    Promise.all([
      fetchCourse(),
      fetchLikedReview(),
      setCurrentItem(reviewList.slice(0, itemsPerPage)),
    ]).then(() => setProgress(false));
  }, [reviewList]);

  // Handle change
  function handleChange(event, newValue) {
    setValue(newValue);
  }

  // Review sorting
  function handleReviewSort(event) {
    const sortKey = event.target.value;
    setSortReview(sortKey);
    setReviewList(
      sortKey === "helpful"
        ? [...reviewList].sort((a, b) => b.likeCount - a.likeCount)
        : sortKey === "recent"
          ? [...reviewList].sort((a, b) => b.testimonialId - a.testimonialId)
          : [...reviewList]
    );
  }

  // Toggle review-like
  async function handleToggleReviewLike(testimonialId) {
    setProgress(true);
    try {
      await baseApi.post("/testimonial-like-counts/check-like", {
        testimonialId: testimonialId,
        userId: userData.id,
      });
      showReview();
    } catch (error) {
      console.error(error);
    }
  }

  // Handle pagination
  function handlePagination(event, value) {
    setCurrentPage(value);
    const indexOfLastItem = value * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    setCurrentItem(reviewList.slice(indexOfFirstItem, indexOfLastItem));
  }

  return (
    <>
      <Box sx={{ borderBottom: 1, borderColor: "divider" }}>
        <Tabs
          value={value}
          onChange={handleChange}
          aria-label="basic tabs example"
        >
          <Tab className="me-2" label="Description" {...a11yProps(0)} />
          <Tab className="me-2" label="Lessons" {...a11yProps(1)} />
          <Tab className="me-2" label="Reviews" {...a11yProps(2)} />
        </Tabs>
      </Box>

      <CustomTabPanel value={value} index={0}>
        <h3 className="fw-medium text-capitalize my-3">
          {singleCourse.course_title}
        </h3>
        <p className="text-muted">{singleCourse.course_description}</p>
      </CustomTabPanel>

      <CustomTabPanel value={value} index={1}>
        <h3 className=" fw-medium text-capitalize my-3">About</h3>
        <p className="small text-muted mb-4">{singleCourse.course_about}</p>
        <h3 className=" fw-medium text-capitalize my-3">Lessons</h3>
        <ul>
          {lessons.map((lesson) => {
            return (
              <Link
                to={
                  userToken
                    ? `/course/${lesson.course_id}/lesson/${lesson.lessonId}`
                    : "/login"
                }
                className=" text-decoration-none text-black"
                key={lesson.lessonId}
              >
                <li className="list-unstyled my-3">
                  <i className="fa-solid fa-video fa-lg me-3"></i>
                  <span className="text-capitalize videoList">
                    {lesson.lesson_name}
                  </span>
                </li>
              </Link>
            );
          })}
        </ul>
      </CustomTabPanel>

      <CustomTabPanel value={value} index={2}>
        <h3 className="my-3">Review</h3>
        {userToken ? (
          <ReviewForm
            singleCourse={singleCourse}
            progress={progress}
            setProgress={setProgress}
            showReview={showReview}
            userData={userData}
          />
        ) : (
          <p className="my-5 text-muted">
            You must be{" "}
            <span>
              <Link to="/login"> logged in </Link>
            </span>{" "}
            to post a review.
          </p>
        )}

        <div className="my-4 text-end">
          <FormControl
            sx={{ m: 1, minWidth: 130 }}
            size="small"
            className="bg-white"
          >
            <InputLabel id="demo-sort-select-label">
              Most {sortReview || "recent"}
            </InputLabel>
            <Select
              labelId="demo-sort-select-label"
              id="demo-sort-select"
              label="Most recent"
              margin="dense"
              className="text-capitalize"
              value={sortReview}
              onChange={handleReviewSort}
            >
              <MenuItem value="recent">Most recent</MenuItem>
              <MenuItem value="helpful">Most liked</MenuItem>
            </Select>
          </FormControl>
        </div>

        {reviewList.length === 0 ? (
          <p className="text-center text-muted">No reviews yet</p>
        ) : (
          currentItem.map((review) => (
            <div
              className="row my-3 py-3 animate__animated animate__fadeIn border-bottom"
              key={review.testimonialId}
            >
              <div className="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center">
                <ProfileAvatar
                  photo={review.profile_photo_path}
                  name={review.name}
                  width={55}
                  height={55}
                />
              </div>
              <div className="col-lg-10 col-md-8 col-sm-12">
                <div className="d-flex justify-content-between align-items-center">
                  <span className="fs-4 fw-bold text-capitalize">
                    {review.name}
                  </span>
                  <span className="text-muted small">
                    {dateTimeFormat(review.testimonialCreatedAt)}
                    {/* <ReactTimeAgo date={review.testimonialCreatedAt} /> */}
                  </span>
                </div>
                <p className="text-muted">{review.text}</p>
                {userToken ? userData.id !== review.user_id ? (
                  <div className="d-flex justify-content-between align-items-center">
                    <button
                      type="button"
                      className="btn btn-sm border-0 px-0 text-muted"
                      onClick={() =>
                        handleToggleReviewLike(review.testimonialId)
                      }
                    >
                      {likedReviewIdList.includes(review.testimonialId) &&
                        likedReviewUserIdList.includes(review.user_id) ? (
                        <i className="fa-solid fa-thumbs-up fa-xl me-2"></i>
                      ) : (
                        <i className="fa-regular fa-thumbs-up fa-xl me-2"></i>
                      )}
                      {review.likeCount}
                    </button>
                  </div>
                ) : (
                  <IconButton
                    aria-label="delete"
                    size="small"
                    onClick={() => handleReviewDelete(review.testimonialId)}
                  >
                    <DeleteIcon fontSize="small" />
                  </IconButton>
                ) : ""}
              </div>
            </div>
          ))
        )}

        {reviewList.length > itemsPerPage && (
          <div className="row my-5">
            <div className="col-lg-6 offset-lg-6 px-3 d-flex justify-content-center justify-content-lg-end justify-content-md-center align-items-center">
              <PaginationComponent
                list={reviewList}
                itemsPerPage={itemsPerPage}
                currentPage={currentPage}
                handlePagination={handlePagination}
              />
            </div>
          </div>
        )}
      </CustomTabPanel>
    </>
  );
};

export default Tabpanel;

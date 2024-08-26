import React, { useContext } from "react";
import { useState } from "react";
import Navbar from "../../components/navbar/Navbar";
import { useEffect } from "react";
import axios from "axios";
import { Link, useParams } from "react-router-dom";
import { Avatar, Button, Stack } from "@mui/material";
import CheckIcon from "@mui/icons-material/Check";
import DoneAllIcon from "@mui/icons-material/DoneAll";
import LoadingButton from "@mui/lab/LoadingButton";
import BookmarkAddIcon from "@mui/icons-material/BookmarkAdd";
import BookmarkAddedIcon from "@mui/icons-material/BookmarkAdded";
import ReactTimeAgo from "react-time-ago";
import ProfileAvatar from "../../components/ProfileAvatar";
import "./lesson.css";
import { UserDataContext, UserTokenContext } from "../../context/UserContext";
import PaginationComponent from "../../components/PaginationComponent";
import SnackBarComponent from "../../components/snackBar/SnackBarComponent";
import { baseApi } from "../../api/BaseApi";
import dateTimeFormat from "../../context/DateTimeFormat";

const LessonList = ({
  userData,
  lessons,
  lessonDetail,
  lessonId,
  totalLessonCount,
  fetchLessonData,
  completedLessonUserId,
  completedLessonList,
}) => {
  return (
    <>
      <div className="col-md-3 px-0">
        <div className="p-3 rounded">
          <h2 className="text-capitalize fw-bold">
            {lessonDetail.course_title}
          </h2>
          <span className="text-muted">
            <i className="fa-regular fa-circle-play me-2"></i>
            {totalLessonCount} lessons
          </span>
        </div>

        <div className="overflow-auto" style={{ maxHeight: "73.5vh" }}>
          <ul className="list-unstyled ">
            {lessons.map((lesson, index) => {
              return (
                <li
                  className={`text-capitalize lessonBox p-2 ${
                    parseInt(lessonId) === lesson.lessonId &&
                    "lessonList bg-body-tertiary"
                  } `}
                  key={lesson.lessonId}
                >
                  <Link
                    to={`/course/${lesson.course_id}/lesson/${lesson.lessonId}`}
                    className="text-decoration-none text-black d-flex align-items-center lessonBox"
                    onClick={() => fetchLessonData(lesson.lessonId)}
                  >
                    {completedLessonUserId === userData.id &&
                    completedLessonList.includes(lesson.lessonId) ? (
                      <Avatar
                        className="mx-2"
                        style={{ background: "#007bff" }}
                      >
                        <CheckIcon />
                      </Avatar>
                    ) : (
                      <Avatar className="mx-2 text-black">
                        {index < 10 && `0${index + 1}`}
                      </Avatar>
                    )}

                    {lesson.lesson_name}
                  </Link>
                </li>
              );
            })}
          </ul>
        </div>
      </div>
    </>
  );
};

const LessonVideo = ({
  progress,
  setProgress,
  lessonDetail,
  lessonId,
  userData,
  handleCompletedLesson,
  completedLessonUserId,
  setSnackBarOpen,
  completedLessonList,
  likedButtonCommentIdList,
  likedButtonUserIdList,
  fetchLikedButtonList,
}) => {
  return (
    <>
      <div className="col-md-9 overflow-auto" style={{ maxHeight: "87vh" }}>
        <div className="row">
          <div className="col-12 d-flex justify-content-center">
            <video
              src={lessonDetail.lesson_video}
              className="w-75"
              controls
            ></video>
          </div>
        </div>

        <div className="row my-4">
          <div className="col-lg-5 px-3 bor">
            <Stack spacing={3} direction="row">
              <LoadingButton
                loading={progress}
                variant={
                  completedLessonUserId === userData.id &&
                  completedLessonList.includes(lessonDetail.lessonId)
                    ? "contained"
                    : "outlined"
                }
                className="px-5"
                startIcon={
                  completedLessonUserId === userData.id &&
                  completedLessonList.includes(lessonDetail.lessonId) ? (
                    <DoneAllIcon />
                  ) : (
                    <CheckIcon />
                  )
                }
                onClick={handleCompletedLesson}
              >
                {completedLessonUserId === userData.id &&
                completedLessonList.includes(lessonDetail.lessonId)
                  ? "Completed"
                  : "Complete"}
              </LoadingButton>
            </Stack>
          </div>
        </div>

        <div className="row p-3">
          <div className="col-12 shadow rounded-2 px-4">
            <div className="my-4 ">
              <h3 className="fw-bold text-capitalize">
                {lessonDetail.lesson_name}
              </h3>
              <p className="text-muted small">
                Publish Date - {dateTimeFormat(lessonDetail.lessonCreatedAt)}
              </p>
              <p className="my-4">{lessonDetail.lesson_description}</p>
            </div>
            <hr />
            <div className="my-3">
              <h2 className="text-center fw-bold">Instructor</h2>
              <div className="row my-4">
                <div className="col-md-4 d-flex justify-content-center align-items-center">
                  <img
                    src={
                      lessonDetail.author_image === null
                        ? lessonDetail.author_gender === "male"
                          ? "http://localhost:8000/images/default_user.png"
                          : "http://localhost:8000/images/default_female.jpg"
                        : lessonDetail.author_image
                    }
                    alt=""
                    className="w-75 rounded my-3"
                  />
                </div>
                <div className="col-md-8 py-3 d-flex flex-column justify-content-between">
                  <div>
                    <Link
                      to={`/instructor/${lessonDetail.authorId}`}
                      className="text-black authorName"
                    >
                      <h4 className="text-capitalize">
                        {lessonDetail.author_name}
                      </h4>
                    </Link>
                    <p className="my-3 text-muted">
                      {lessonDetail.author_about}
                    </p>
                  </div>
                  <div className="d-flex align-items-center">
                    <a
                      href="https://www.youtube.com/"
                      target="blank"
                      className="text-decoration-none text-black mx-2"
                    >
                      <i className="fa-brands fa-github fa-xl"></i>
                    </a>
                    <a
                      href="https://www.youtube.com/"
                      target="blank"
                      className="text-decoration-none text-black mx-2"
                    >
                      <i className="fa-brands fa-youtube fa-xl"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <CommentSection
            lessonId={lessonId}
            progress={progress}
            setProgress={setProgress}
            setSnackBarOpen={setSnackBarOpen}
            likedButtonCommentIdList={likedButtonCommentIdList}
            likedButtonUserIdList={likedButtonUserIdList}
            fetchLikedButtonList={fetchLikedButtonList}
          />
        </div>
      </div>
    </>
  );
};

const CommentSection = ({
  lessonId,
  progress,
  setProgress,
  setSnackBarOpen,
  likedButtonCommentIdList,
  likedButtonUserIdList,
  fetchLikedButtonList,
}) => {
  // useContext
  const userData = useContext(UserDataContext);
  const userToken = useContext(UserTokenContext);

  // useState
  const [comments, setComments] = useState([]);
  const [commentText, setCommentText] = useState("");

  const [currentPage, setCurrentPage] = useState(1);
  const [currentItem, setCurrentItem] = useState([]);

  const itemsPerPage = 5;

  // Handle comment show
  async function handleCommentShow() {
    try {
      const response = await baseApi.post("/comment/show", {
        lessonId: lessonId,
      });
      setComments(response.data.comments);
    } catch (error) {
      console.error(error);
    }
  }

  // useEffect
  useEffect(() => {
    handleCommentShow();
    fetchLikedButtonList();
  }, [lessonId]); // This useEffect will trigger whenever lessonId changes

  useEffect(() => {
    setCurrentItem(comments.slice(0, itemsPerPage));
  }, [comments]); // This useEffect will trigger whenever comments change

  // Handle pagination
  function handlePagination(event, value) {
    setCurrentPage(value);
    const indexOfLastItem = value * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    setCurrentItem(comments.slice(indexOfFirstItem, indexOfLastItem));
  }

  function handleCommentText(event) {
    setCommentText(event.target.value);
  }

  function handleSubmitComment(event) {
    event.preventDefault();
    setProgress(true);
    axios
      .post("http://localhost:8000/api/comment/store", {
        userId: userData.id,
        lessonId: lessonId,
        commentText: commentText,
      })
      .then(() => {
        setCommentText("");
        handleCommentShow();
        setProgress(false);
      })
      .catch((error) => console.error(error));
  }

  function handleToggleCommentLike(commentId) {
    setProgress(true);
    axios
      .post("http://localhost:8000/api/comment-like-count/check-like", {
        reviewId: commentId,
        userId: userData.id,
      })
      .then(() => {
        handleCommentShow();
        fetchLikedButtonList();
        setProgress(false);
      })

      .catch((error) => console.error(error));
  }

  // Comment delete
  function handleCommentDelete(commentId) {
    setProgress(true);
    axios
      .post("http://localhost:8000/api/comment/destroy", {
        reviewId: commentId,
      })
      .then(() => {
        handleCommentShow();
        setSnackBarOpen(true);
        setInterval(() => {
          setSnackBarOpen(false);
        }, [4000]);
        setProgress(false);
      })
      .catch((error) => console.error(error));
  }

  return (
    <>
      <div className="col-12 shadow rounded-3 my-5 px-5 py-4">
        <h2 className="text-center fw-bold">Comment</h2>
        <div className="row my-4">
          <div className="col-md-2 py-2 d-flex justify-content-center">
            <ProfileAvatar
              photo={userData.profile_photo_path}
              name={userData.name}
              width={70}
              height={70}
            />
          </div>
          <div className="col-md-10 py-2 text-end">
            <form onSubmit={handleSubmitComment}>
              <textarea
                placeholder="Give a comment"
                id=""
                cols="25"
                rows="7"
                className="form-control"
                value={commentText}
                onChange={handleCommentText}
              ></textarea>

              <LoadingButton
                type="submit"
                loading={progress}
                variant="contained"
                className="my-3"
              >
                Submit
              </LoadingButton>
            </form>
          </div>
        </div>
        <hr className="mb-5" />

        {comments.length > 0 ? (
          currentItem.map((comment) => {
            return (
              <div
                className="row my-3 py-3 border rounded animate__animated animate__fadeIn"
                key={comment.reviewId}
              >
                <div className="col-lg-2 col-md-4 col-sm-12 d-flex justify-content-center align-items-center">
                  <ProfileAvatar
                    photo={comment.profile_photo_path}
                    name={comment.name}
                    width={60}
                    height={60}
                  />
                </div>
                <div className="col-lg-10 col-md-8 col-sm-12">
                  <div className="d-flex justify-content-between align-items-center">
                    <span className="fs-4 fw-bold text-capitalize">
                      {comment.name}
                    </span>
                    <span className="text-muted small">
                      {comment.reviewCreatedAt.slice(0, 10)}
                    </span>
                  </div>
                  <p className="text-muted">{comment.review_text}</p>
                  {userToken ? (
                    <div className="d-flex justify-content-between align-items-center">
                      {userData.email !== comment.email && (
                        <button
                          type="button"
                          className="btn btn-sm border-0 px-0 text-muted reviewLikeBtn"
                          onClick={() =>
                            handleToggleCommentLike(comment.reviewId)
                          }
                        >
                          {likedButtonCommentIdList.includes(
                            comment.reviewId
                          ) && likedButtonUserIdList.includes(userData.id) ? (
                            <i className="fa-solid fa-thumbs-up fa-xl me-2"></i>
                          ) : (
                            <i className="fa-regular fa-thumbs-up fa-xl me-2"></i>
                          )}

                          {comment.likeCount}
                        </button>
                      )}
                      {userData.email === comment.email && (
                        <button
                          className="btn btn-sm shadow-sm"
                          type="button"
                          onClick={() => handleCommentDelete(comment.reviewId)}
                        >
                          <i className="fa-solid fa-trash-can"></i>
                        </button>
                      )}
                    </div>
                  ) : (
                    <div className="d-flex justify-content-between align-items-center">
                      <Link to="/login">
                        <button
                          type="button"
                          className="btn btn-sm border-0 px-0 text-muted reviewLikeBtn"
                        >
                          <i className="fa-regular fa-thumbs-up fa-xl me-2"></i>
                          {/* {review.likeCount} */}
                        </button>
                      </Link>
                    </div>
                  )}
                </div>
              </div>
            );
          })
        ) : (
          <p className="text-center">No comments yet...</p>
        )}

        {comments.length > itemsPerPage && (
          <div className="row my-5">
            <div className="col-lg-6 offset-lg-6 px-3 d-flex justify-content-center justify-content-lg-end justify-content-md-center align-items-center">
              <PaginationComponent
                list={comments}
                itemsPerPage={itemsPerPage}
                currentPage={currentPage}
                handlePagination={handlePagination}
              />
            </div>
          </div>
        )}
      </div>
    </>
  );
};

const Lesson = () => {
  // useContext
  const userData = useContext(UserDataContext);

  // useParams
  const { courseId } = useParams();
  const { lessonId } = useParams();

  // useState
  const [progress, setProgress] = useState(false);
  const [snackBarOpen, setSnackBarOpen] = useState(false);

  const [lessons, setLessons] = useState([]);
  const [lessonDetail, setLessonDetail] = useState({});
  const [totalLessonCount, setTotalLessonCount] = useState(0);

  const [completedLessonUserId, setCompletedLessonIdUserId] = useState(null);
  const [completedLessonId, setCompletedLessonId] = useState(null);
  const [completedLessonList, setCompletedLessonList] = useState([]);

  const [likedButtonCommentIdList, setLikedButtonCommentIdList] = useState([]);
  const [likedButtonUserIdList, setLikedButtonUserIdList] = useState([]);

  // Course show
  async function courseShow() {
    try {
      const response = await baseApi.post("/course/show", {
        courseId: courseId,
      });
      setLessons(response.data.lessons);
      setTotalLessonCount(response.data.totalLessonCount);
    } catch (error) {
      console.error(error);
    }
  }

  // Fetch completed lesson list
  async function fetchCompletedLessonList() {
    try {
      const response = await baseApi.get("/completed-lessons");
      setCompletedLessonList(
        response.data.completedLessons.map((item) => item.lesson_id)
      );
    } catch (error) {
      console.error(error);
    }
  }

  // Fetch lesson
  async function fetchLessonData() {
    try {
      const response = await baseApi.post("/lesson/show", {
        lessonId: lessonId,
      });
      setLessonDetail(response.data.lessons);
    } catch (error) {
      console.log(error);
    }
  }

  // useEffect
  useEffect(() => {
    setProgress(true);
    Promise.all([
      courseShow(),
      fetchCompletedLessonList(),
      fetchLessonData(),
    ]).then(() => setProgress(false));
  }, [courseId, lessonId]);

  // Fetch completed lesson
  async function fetchCompletedLessonData() {
    try {
      const response = await baseApi.post("/completed-lesson/show", {
        lessonId: lessonId,
        userId: userData.id,
      });
      if (response.data.completedLessons) {
        setCompletedLessonIdUserId(response.data.completedLessons.user_id);
        setCompletedLessonId(response.data.completedLessons.lesson_id);
      }
    } catch (error) {
      console.error(error);
    }
  }

  async function handleCompletedLesson() {
    // setProgress(true);
    try {
      await baseApi.post("/completed-lesson/check-completed-lesson", {
        userId: userData.id,
        lessonId: lessonId,
      });
      fetchCompletedLessonData();
      fetchCompletedLessonList();
    } catch (error) {
      console.error(error);
    }
  }

  // Fetch liked button list
  async function fetchLikedButtonList() {
    try {
      const response = await baseApi.get("/comment-like-counts");
      setLikedButtonCommentIdList(response.data.map((item) => item.review_id));
      setLikedButtonUserIdList(response.data.map((item) => item.user_id));
    } catch (error) {
      console.error(error);
    }
  }

  return (
    <>
      <Navbar progress={progress} />

      <main>
        <div className="row">
          <LessonList
            userData={userData}
            progress={progress}
            lessons={lessons}
            lessonDetail={lessonDetail}
            lessonId={lessonId}
            totalLessonCount={totalLessonCount}
            fetchLessonData={fetchLessonData}
            completedLessonUserId={completedLessonUserId}
            completedLessonList={completedLessonList}
          />
          <LessonVideo
            progress={progress}
            setProgress={setProgress}
            lessonDetail={lessonDetail}
            lessonId={lessonId}
            userData={userData}
            // fetchCompletedLessonData={fetchCompletedLessonData}
            completedLessonUserId={completedLessonUserId}
            completedLessonId={completedLessonId}
            handleCompletedLesson={handleCompletedLesson}
            setSnackBarOpen={setSnackBarOpen}
            completedLessonList={completedLessonList}
            likedButtonCommentIdList={likedButtonCommentIdList}
            likedButtonUserIdList={likedButtonUserIdList}
            fetchLikedButtonList={fetchLikedButtonList}
          />
        </div>
      </main>

      <SnackBarComponent
        snackBarOpen={snackBarOpen}
        snackBarMsg={"Comment is deleted"}
      />
    </>
  );
};

export default Lesson;

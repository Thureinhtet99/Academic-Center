import { useEffect, useState } from "react";
import Navbar from "../../components/navbar/Navbar";
import "./courseDetails.css";
import Tabpanel from "../../components/tabPanel/TabPanel";
import SnackBarComponent from "../../components/snackBar/SnackBarComponent";
import { Link, useLocation, useParams } from "react-router-dom";
import LatestCourse from "../../components/latestCourse/LatestCourse";
import Button from "@mui/material/Button";
import TopNavigation from "../../components/topNavigation/TopNavigation";
import Skeleton from "@mui/material/Skeleton";
import { baseApi } from "../../api/BaseApi";

const CourseStatus = ({ progress, singleCourse, reviewCount }) => {
  return (
    <>
      <div className="row py-2 courseDetailsTitles rounded">
        <div className="col text-center border-end border-2 px-4">
          <h4 className="fw-medium">Instructor</h4>
          <p className="text-capitalize small placeholder-glow">
            {progress ? (
              <span className="placeholder col-3"></span>
            ) : (
              <Link
                className="text-black"
                to={`/instructor/${singleCourse.authorId}`}
              >
                {singleCourse.author_name}
              </Link>
            )}
          </p>
        </div>
        <div className="col text-center border-end border-2 px-4">
          <h4 className="fw-medium">Reviews</h4>
          <p className="text-capitalize small placeholder-glow">
            {progress ? (
              <span className="placeholder col-1"></span>
            ) : (
              <span>{reviewCount}</span>
            )}
          </p>
        </div>
        <div className="col text-center px-4">
          <h4 className="fw-medium">Categories</h4>
          <p className="text-capitalize small placeholder-glow">
            {progress ? (
              <span className="placeholder col-2"></span>
            ) : (
              singleCourse.category_name
            )}
          </p>
        </div>
      </div>

      {/* Big Image */}
      <div className="row my-4">
        <div className="col px-0 border ">
          {progress ? (
            <Skeleton variant="rectangular" width={"maxWidth"} height={450} />
          ) : (
            <img
              src={
                singleCourse.course_image
                  ? `http://localhost:8000/storage/${singleCourse.course_image}`
                  : "http://localhost:8000/images/default-image.png"
              }
              alt=""
              className="w-100 object-fit-cover rounded"
              style={{ height: "28rem" }}
            />
          )}
        </div>
      </div>
    </>
  );
};

const InstructorSection = ({ progress, singleCourse }) => {
  return (
    <>
      <div className="col-12 my-5">
        <h3 className="fw-bold">Instructor</h3>
        {progress ? (
          <div className="text-center my-5">
            <div className="spinner-border" role="status">
              <span className="visually-hidden">Loading...</span>
            </div>
          </div>
        ) : (
          <>
            <div className="d-flex align-items-center my-4 ">
              <div>
                <Link to={`/instructor/${singleCourse.authorId}`}>
                  <img
                    src={
                      singleCourse.author_image === null
                        ? singleCourse.author_gender === "male"
                          ? "http://localhost:8000/images/default_user.png"
                          : "http://localhost:8000/images/default_female.jpg"
                        : `http://localhost:8000/storage/${singleCourse.author_image}`
                    }
                    alt=""
                    className="object-fit-cover rounded"
                    style={{ width: "7rem", height: "7rem" }}
                  />
                </Link>
              </div>
              <div className="mx-4">
                <Link
                  to={`/instructor/${singleCourse.authorId}`}
                  className="fs-4 text-capitalize text-black authorName"
                >
                  {singleCourse.author_name}
                </Link>
                <p className="text-capitalize small">
                  {singleCourse.author_degree}
                </p>
              </div>
            </div>
            <p className="text-muted ">{singleCourse.course_description}</p>
          </>
        )}
      </div>
    </>
  );
};

const CourseDetails = () => {
  // useState
  const [progress, setProgress] = useState(false);
  const [userData, setUserData] = useState({});
  const [userToken, setUserToken] = useState("");
  const [snackBarOpen, setSnackBarOpen] = useState(false);
  const [singleCourse, setSingleCourse] = useState({});
  const [totalLessonCount, setTotalLessonCount] = useState(null);
  const [reviewList, setReviewList] = useState([]);
  const [reviewCount, setReviewCount] = useState(0);
  const [latestCourseList, setLatestCourseList] = useState([]);

  const location = useLocation();

  // useParams
  const { courseId } = useParams();

  // Show review
  async function showReview() {
    try {
      const response = await baseApi.post("/testimonial/show", {
        courseId: courseId,
      });
      setReviewList(response.data.testimonials);
      setReviewCount(response.data.testimonialLength);
    } catch (error) {
      console.error(error);
    }
  }

  // Fetch course
  async function fetchCourse() {
    try {
      const response = await baseApi.get("/courses");
      setLatestCourseList(response.data.latestCourses);
      setSingleCourse(response.data.courses);
      setTotalLessonCount(response.data.totalLessonCount);
    } catch (error) {
      console.error(error);
    }
  }

  // Show course
  async function showCourse() {
    try {
      const response = await baseApi.post("/course/show", {
        courseId: courseId,
      });
      setSingleCourse(response.data.courses);
      setTotalLessonCount(response.data.totalLessonCount);
    } catch (error) {
      console.error(error);
    }
  }

  useEffect(() => {
    const storedUserData = JSON.parse(localStorage.getItem("userData"));
    const storedUserToken = JSON.parse(localStorage.getItem("userToken"));
    if (storedUserData && storedUserToken) {
      setUserData(storedUserData);
      setUserToken(storedUserToken);
    }

    Promise.all([
      setProgress(true),
      showReview(),
      fetchCourse(),
      showCourse(),
    ]).then(() => setProgress(false));
  }, [courseId]);

  // Delete review
  async function handleReviewDelete(reviewId) {
    setProgress(true);
    try {
      await baseApi.post("/testimonial/destroy", {
        testimonialId: reviewId,
      });
      setSnackBarOpen(true);
      showReview();
      setTimeout(() => {
        setSnackBarOpen(false);
      }, 4000);
    } catch (error) {
      console.error(error);
    }
  }

  return (
    <>
      <Navbar progress={progress} />

      <main>
        <TopNavigation
          progress={progress}
          location={location.pathname}
          linkName={"courses"}
          singleCourse={singleCourse}
        />

        <div className="row py-5">
          <div className="col-6 px-5 align-self-center placeholder-glow">
            <h1 className="text-capitalize fw-bold text-start ">
              {progress ? (
                <span className="placeholder col-6"></span>
              ) : (
                singleCourse.course_title
              )}
            </h1>
          </div>
          <div className="col-6 px-5 align-self-center text-end">
            <Link to={`/course/${courseId}/lesson/${singleCourse.lessonId}`}>
              <Button type="button" variant="contained" size="large">
                Start Learning
              </Button>
            </Link>
          </div>
        </div>

        <div className="row">
          <div className="col-lg-8 px-5">
            <CourseStatus
              progress={progress}
              singleCourse={singleCourse}
              reviewCount={reviewCount}
            />

            {/* Tab */}
            <div className="row mb-5 pb-5 border">
              <div className="col-12">
                <Tabpanel
                  userData={userData}
                  userToken={userToken}
                  singleCourse={singleCourse}
                  setReviewList={setReviewList}
                  reviewList={reviewList}
                  showReview={showReview}
                  progress={progress}
                  setProgress={setProgress}
                  courseId={courseId}
                  handleReviewDelete={handleReviewDelete}
                />
              </div>
            </div>
          </div>

          <div className="col-lg-4 px-4">
            <div className="row">
              <div className="col-12">
                <h3 className="fw-bold">Course Details</h3>
                <ul className="my-4 list-unstyled">
                  <li className="my-3 d-flex justify-content-between align-items-center fs-4 placeholder-glow">
                    {progress ? (
                      <span className="placeholder col-2"></span>
                    ) : singleCourse.course_price > 0 ? (
                      singleCourse.course_price + "Ks"
                    ) : (
                      "Free"
                    )}
                  </li>
                  <li className="my-2 d-flex justify-content-between align-items-center">
                    <div>
                      <i className="fa-regular fa-clock"></i>
                      <span className="ms-3">Duration:</span>
                    </div>
                    <div className="placeholder-glow">
                      <span>{singleCourse.course_duration} months</span>
                    </div>
                  </li>
                  <li className="my-2 d-flex justify-content-between align-items-center">
                    <div>
                      <i className="fa-solid fa-book-open"></i>
                      <span className="ms-3">Lessons:</span>
                    </div>
                    <div className="">
                      <span>{totalLessonCount}</span>
                    </div>
                  </li>
                </ul>
              </div>

              <InstructorSection
                progress={progress}
                singleCourse={singleCourse}
              />

              <div className="col-12">
                <LatestCourse latestCourseList={latestCourseList} />
              </div>
            </div>
          </div>
        </div>
      </main>

      <SnackBarComponent
        snackBarOpen={snackBarOpen}
        snackBarMsg={"Your review is deleted"}
      />
    </>
  );
};

export default CourseDetails;

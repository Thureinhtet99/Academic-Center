import React, { useEffect, useState } from "react";
import Navbar from "../../components/navbar/Navbar";
import { Avatar, Box, TextField } from "@mui/material";
import SearchIcon from "@mui/icons-material/Search";
import EmailIcon from "@mui/icons-material/Email";
import GitHubIcon from "@mui/icons-material/GitHub";
import FacebookIcon from "@mui/icons-material/Facebook";
import LinkedInIcon from "@mui/icons-material/LinkedIn";
import CourseCardComponent from "../../components/courseCard/CourseCardComponent";
import PaginationComponent from "../../components/PaginationComponent";
import "./profile.css";
import { baseApi } from "../../api/BaseApi";
import { Link, useParams } from "react-router-dom";

const ProfileHeading = ({ userData }) => {
  const isGooglePhoto =
    userData.profile_photo_path &&
    userData.profile_photo_path.startsWith("http");

  return (
    <>
      <div className="row d-flex align-items-center">
        <div className="col-lg-3 col-md-12 my-4 d-flex justify-content-center">
          <Avatar
            src={
              isGooglePhoto
                ? userData.profile_photo_path
                : `http://localhost:8000/storage/${userData.profile_photo_path}`
            }
            name={userData.name}
            sx={{ width: 200, height: 200 }}
            variant="rounded border"
          />
        </div>
        <div className="col-lg-8 col-md-12">
          <h2 className="text-capitalize text-lg-start text-md-center">
            {userData.name}
          </h2>
          <p className="text-lg-start text-md-center">
            <span className="me-1">
              <EmailIcon />
            </span>
            {userData.email}
          </p>
          {userData.about && (
            <p className="text-center small py-3 px-5 border rounded userAbout">
              {userData.about}
            </p>
          )}
          <div className="d-flex justify-content-start justify-content-md-center align-items-center gap-3 my-3">
            {userData.github_link && (
              <Link to={userData.github_link}>
                <GitHubIcon fontSize="large" />
              </Link>
            )}
            {userData.facebook_link && (
              <Link to={userData.facebook_link}>
                <FacebookIcon fontSize="large" />
              </Link>
            )}
            {userData.linkedin_link && (
              <Link to={userData.linkedin_link}>
                <LinkedInIcon fontSize="large" />
              </Link>
            )}
          </div>
        </div>
      </div>
    </>
  );
};

const ProfileBody = ({
  courseCardList,
  currentPage,
  setCurrentPage,
  currentItem,
  setCurrentItem,
  itemsPerPage,
}) => {
  // Search course
  const handleSearch = (event) => {
    const filteredCourses = courseCardList.filter((course) => {
      return course.course_title
        .toLowerCase()
        .includes(event.target.value.toLowerCase());
    });
    setCurrentItem(filteredCourses.slice(0, itemsPerPage));
    setCurrentPage(1);
  };

  const handlePagination = (event, value) => {
    setCurrentPage(value);
    const indexOfLastItem = value * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    setCurrentItem(courseCardList.slice(indexOfFirstItem, indexOfLastItem));
  };

  return (
    <>
      <div className="row d-flex justify-content-center mx-5 mt-5 pt-5">
        <h2 className="text-center">My Courses</h2>
        <div className="col-8 my-3">
          <Box sx={{ display: "flex", alignItems: "flex-end" }}>
            <SearchIcon sx={{ color: "action.active", mr: 1, my: 0.5 }} />
            <TextField
              fullWidth
              id="input-with-sx"
              label="Search"
              variant="standard"
              onChange={handleSearch}
            />
          </Box>
        </div>
      </div>

      <div className="row d-flex justify-content-center align-items-center m-5">
        {currentItem.map((courseCard) => {
          return (
            <div
              className="col-xl-3 col-lg-4 col-md-6 my-3 gap-3 d-flex justify-content-center align-items-center"
              key={courseCard.ownCourseId}
            >
              <CourseCardComponent
                course={courseCard}
                lessonCounts={courseCard.lessonCounts}
                width="16"
              />
            </div>
          );
        })}
      </div>
      <div className="row my-5">
        <div className="col-lg-12 d-flex justify-content-center align-items-center">
          <PaginationComponent
            list={courseCardList}
            itemsPerPage={itemsPerPage}
            currentPage={currentPage}
            handlePagination={handlePagination}
          />
        </div>
      </div>
    </>
  );
};

const Profile = () => {
  // useState
  const [progress, setProgress] = useState(false);

  const [userData, setUserData] = useState({});

  const [courseCardList, setCourseCardList] = useState([]);

  const [currentPage, setCurrentPage] = useState(1);
  const [currentItem, setCurrentItem] = useState([]);

  const itemsPerPage = 8;

  // userParams
  const { userId } = useParams();

  // Fetch own-course
  async function fetchOwnCourse() {
    try {
      const response = await baseApi.post("/own-course/show", {
        userId: userId,
      });
      setCourseCardList(response.data.ownCourses);
      setCurrentItem(response.data.ownCourses.slice(0, itemsPerPage));
    } catch (error) {
      console.error(error);
    }
  }

  // useEffect
  useEffect(() => {
    setProgress(true);
    Promise.all([
      setUserData(JSON.parse(localStorage.getItem("userData"))),
      fetchOwnCourse(),
    ]).then(() => setProgress(false));
  }, [userId]);

  return (
    <>
      <Navbar progress={progress} />
      <main>
        <ProfileHeading userData={userData} />
        <ProfileBody
          courseCardList={courseCardList}
          currentItem={currentItem}
          setCurrentItem={setCurrentItem}
          currentPage={currentPage}
          setCurrentPage={setCurrentPage}
          itemsPerPage={itemsPerPage}
        />
      </main>
    </>
  );
};

export default Profile;

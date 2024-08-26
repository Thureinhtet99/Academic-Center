import * as React from "react";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";
import CardMedia from "@mui/material/CardMedia";
import Typography from "@mui/material/Typography";
import { CardActionArea, Chip } from "@mui/material";
import { Link } from "react-router-dom";
import { useContext } from "react";
import { UserDataContext } from "../../context/UserContext";
import { baseApi } from "../../api/BaseApi";

export default function BlogCardComponent({
  blogId,
  blogImg,
  blogTitle,
  categoryName,
  blogDesc,
  blogCreatedAt,
}) {
  // useContext
  const userDataContext = useContext(UserDataContext);

  // Handle blog card
  async function handleBlogCard(blogId) {
    const response = await baseApi.post("/blog-action-logs/store", {
      userId: userDataContext.id,
      blogId: blogId,
    });
    console.log(response.data);
  }

  return (
    <>
      <Link
        to={`/blog/${blogId}`}
        className="text-decoration-none"
        onClick={() => handleBlogCard(blogId)}
      >
        <Card sx={{ maxWidth: 380 }}>
          <CardActionArea>
            {blogImg && (
              <CardMedia
                component="img"
                height="200"
                image={`http://localhost:8000/storage/${blogImg}`}
              />
            )}

            <CardContent>
              <Typography
                gutterBottom
                variant="h6"
                component="div"
                className="fw-bold text-capitalize"
              >
                {blogTitle.length > 36
                  ? blogTitle.slice(0, 35) + "..."
                  : blogTitle}
              </Typography>
              <div className="d-flex justify-content-between align-items-center my-2">
                <Chip className="text-capitalize" label={categoryName} />
                <span className="text-capitalize small text-muted">
                  {blogCreatedAt.slice(0, 10)}
                </span>
              </div>
              <p className="text-muted small" color="text">
                {blogDesc.length > 121
                  ? blogDesc.slice(0, 120) + "....."
                  : blogDesc}
              </p>
            </CardContent>
          </CardActionArea>
        </Card>
      </Link>
    </>
  );
}

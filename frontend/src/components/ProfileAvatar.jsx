import { Avatar } from "@mui/material";

export default function ProfileAvatar({ photo, name, width, height }) {
  const isGooglePhoto = photo && photo.startsWith("http");

  return (
    <>
      {photo ? (
        <Avatar
          src={isGooglePhoto ? photo : `http://localhost:8000/storage/${photo}`}
          alt=""
          sx={{ width: width, height: height }}
        />
      ) : (
        <Avatar sx={{ width: width, height: height }}>
          {name && name.slice(0, 1).toUpperCase()}
        </Avatar>
      )}
    </>
  );
}

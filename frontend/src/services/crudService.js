const baseURL = `${process.env.VUE_APP_API_BASE_URL}/api/crud.api.php`;

export const updateItem = async (payload) => {
  try {
    const response = await fetch(`${baseURL}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });
    if (!response.ok) {
      throw new Error("Network error while updating item!");
    }
    return await response.json();
  } catch (error) {
    console.error("Error in updateItem service:", error);
    throw error;
  }
};

export const addNewItem = async (payload) => {
  try {
    const response = await fetch(`${baseURL}/add`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });
    if (!response.ok) {
      throw new Error("Network error while adding new item!");
    }
    return await response.json();
  } catch (error) {
    console.error("Error in addNewItem service:", error);
    throw error;
  }
};

export const removeItem = async (payload) => {
  try {
    const response = await fetch(`${baseURL}/delete`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });
    if (!response.ok) {
      throw new Error("Network error while removing item!");
    }
    return await response.json();
  } catch (error) {
    console.error("Error in removeItem service:", error);
    throw error;
  }
};

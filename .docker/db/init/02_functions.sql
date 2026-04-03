CREATE OR REPLACE FUNCTION update_updated_at_column() RETURNS TRIGGER AS $$
BEGIN
  NEW.updated_at = NOW();
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER set_updated_at BEFORE UPDATE ON users FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER set_updated_at BEFORE UPDATE ON movies FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER set_updated_at BEFORE UPDATE ON movies_reviews FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE FUNCTION cleanup_expired_tokens()
RETURNS void AS $$
BEGIN DELETE FROM users_tokens WHERE expires_at < NOW(); END;
$$ LANGUAGE plpgsql;
